<?php

namespace App\Services\Reaction;

use App\Models\Reaction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

class ReactionService
{
    public function store(Model $reactionable, string $type): void
    {
        $user = auth()->user();

        if (!$user) {
            throw ValidationException::withMessages([
                'auth' => 'You must be logged in to react.',
            ]);
        }

        if (!in_array($type, Reaction::$ACTIONS, true)) {
            throw ValidationException::withMessages([
                'type' => 'Invalid reaction type.',
            ]);
        }

        $key = "reaction:{$user->id}";
        if (RateLimiter::tooManyAttempts($key, 5)) {
            throw ValidationException::withMessages([
                'rate_limit' => 'You are reacting too quickly. Please wait a moment.',
            ]);
        }
        RateLimiter::hit($key, 10);

        DB::beginTransaction();
        try {
            $existing = $reactionable->reactions()
                ->where('user_id', $user->id)
                ->first();

            $removed = false;
            $oldType = null;

            if ($existing) {
                $oldType = $existing->action;
                if ($existing->action === $type) {
                    $existing->delete();
                    $removed = true;
                } else {
                    $existing->update(['action' => $type]);
                }
            } else {
                $reactionable->reactions()->create([
                    'user_id' => $user->id,
                    'action' => $type,
                ]);
            }

            $this->updateReactionCounters($reactionable, $type, $oldType, $removed);
            DB::commit();
        } catch (ValidationException $exception) {
            DB::rollBack();
            throw $exception;
        }
    }

    private function updateReactionCounters(Model $reactionable, ?string $newType, ?string $oldType, bool $removed): void
    {
        $columns = $reactionable->getConnection()
            ->getSchemaBuilder()
            ->getColumnListing($reactionable->getTable());

        $hasLikes = in_array('like_count', $columns);
        $hasDislikes = in_array('dislike_count', $columns);

        if (!$hasLikes && !$hasDislikes) {
            return;
        }

        $changes = [];

        if ($removed) {
            if ($newType === 'like' && $hasLikes) {
                $changes['like_count'] = DB::raw('GREATEST(like_count - 1, 0)');
            } elseif ($newType === 'dislike' && $hasDislikes) {
                $changes['dislike_count'] = DB::raw('GREATEST(dislike_count - 1, 0)');
            }
        } else {
            if ($oldType && $oldType !== $newType) {
                if ($oldType === 'like' && $hasLikes) {
                    $changes['like_count'] = DB::raw('GREATEST(like_count - 1, 0)');
                } elseif ($oldType === 'dislike' && $hasDislikes) {
                    $changes['dislike_count'] = DB::raw('GREATEST(dislike_count - 1, 0)');
                }
            }

            if ($newType === 'like' && $hasLikes) {
                $changes['like_count'] = DB::raw('like_count + 1');
            } elseif ($newType === 'dislike' && $hasDislikes) {
                $changes['dislike_count'] = DB::raw('dislike_count + 1');
            }
        }

        if (!empty($changes)) {
            DB::table($reactionable->getTable())
                ->where('id', $reactionable->id)
                ->update($changes);
        }
    }
}
