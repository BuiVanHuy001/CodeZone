<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Lesson;
use App\Models\Reaction;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

class ReactionSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();
        $this->generateReactionForReviews($users);
        $this->generateReactionForComments($users);
    }

    private function generateReactionForReviews(Collection $users): void
    {
        $reviews = Review::all();

        foreach ($reviews as $review) {
            if (fake()->boolean(40)) {
                $likesCount = fake()->numberBetween(1, 30);
                $likedUsers = $users->random($likesCount);
                foreach ($likedUsers as $user) {
                    $this->createReaction('like', $review, $user->id);
                }
                $review->update([
                    'like_count' => $likesCount,
                ]);
            }
            if (fake()->boolean(20)) {
                $dislikesCount = fake()->numberBetween(1, 10);
                if (isset($likedUsers)) {
                    $dislikedUsers = $users->diff($likedUsers)->random($dislikesCount);
                } else {
                    $dislikedUsers = $users->random($dislikesCount);
                }
                foreach ($dislikedUsers as $user) {
                    $this->createReaction('dislike', $review, $user->id);
                }
                $review->update([
                    'dislike_count' => $dislikesCount,
                ]);
            }
        }
    }

    private function generateReactionForComments(Collection $users): void
    {
        $comments = Comment::all();

        foreach ($comments as $comment) {
            if (fake()->boolean(40)) {
                $likesCount = fake()->numberBetween(1, 40);
                $comment->update(['like_count' => $likesCount,]);
            }
            if (fake()->boolean(20)) {
                $dislikesCount = fake()->numberBetween(1, 20);
                $comment->update(['dislike_count' => $dislikesCount,]);
            }
        }
    }

    private function createReaction(string $action, Model $modelable, int $userId): void
    {
        Reaction::create([
            'reactionable_id' => $modelable->id,
            'reactionable_type' => get_class($modelable),
            'user_id' => $userId,
            'action' => $action,
        ]);
    }
}
