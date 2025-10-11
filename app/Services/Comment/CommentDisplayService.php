<?php

namespace App\Services\Comment;

use App\Models\Comment;
use App\Services\Instructor\InstructorService;
use App\Services\Student\StudentService;
use App\Traits\HasNumberFormat;
use Illuminate\Support\Collection;

class CommentDisplayService
{
    use HasNumberFormat;

    public function getComments($commentable): Collection
    {
        return $commentable->comments()
            ->with('user')
            ->withCount('replies')
            ->latest()
            ->get()
            ->map(fn($comment) => $this->decorateData($comment));
    }

    private function decorateData(Comment $comment): Comment
    {
        $replyCount = $comment->replies()->count();
        if ($replyCount > 0) {
            $comment->replyCountText = $this->formatCount($replyCount, 'reply');
        }
        $instructorService = app(InstructorService::class);
        $studentService = app(StudentService::class);
        if ($comment->user->isInstructor()) {
            $comment->user = $instructorService->prepareBasicDetails($comment->user);
        } else {
            $comment->user = $studentService->prepareBasicDetails($comment->user);
        }

        return $comment;
    }

    public function getReplies(Comment $comment): Collection
    {
        return $comment->replies()
            ->with('user')
            ->withCount('replies')
            ->latest()
            ->orderBy('created_at')
            ->get()
            ->map(function ($reply) {
                $reply->content = $this->highlightMentions($reply);

                $reply->user = $reply->user->isInstructor()
                    ? app(InstructorService::class)->prepareBasicDetails($reply->user)
                    : app(StudentService::class)->prepareBasicDetails($reply->user);

                return $reply;
            });
    }

    private function highlightMentions(Comment $comment): string
    {
        $escaped = e((string)$comment->content);

        $mentions = $comment->mentions ?? collect();
        if ($mentions->isEmpty()) {
            return $escaped;
        }

        $mentionData = $mentions->map(function ($m) {
            $user = $m->user;
            if (!$user) return null;
            $name = (string)($user->name ?? '');
            return [
                'user' => $user,
                'name' => $name,
                'norm' => $this->normalizeUsername($name),
                'url' => $user->isInstructor()
                    ? route('instructor.details', $user->slug)
                    : route('student.details', $user->slug),
            ];
        })->filter()->values();

        if ($mentionData->isEmpty()) {
            return $escaped;
        }

        $variants = [];
        foreach ($mentionData as $d) {
            $name = $d['name'];
            $first = strtok($name, ' ');

            $variants[] = preg_quote($name, '/');
            if ($first && mb_strlen($first) < mb_strlen($name)) {
                $variants[] = preg_quote($first, '/');
            }
            $variants[] = preg_quote($this->removeDiacritics($name), '/');
        }
        $variants = array_values(array_unique($variants));
        usort($variants, fn($a, $b) => mb_strlen($b) <=> mb_strlen($a));

        $pattern = '/(?<!\S)(@?(?:' . implode('|', $variants) . '))(?=(?:\s|$|[.,;:!?\)\]\-]))/ui';

        return preg_replace_callback($pattern, function ($matches) use ($mentionData) {
            $matched = $matches[1];
            $clean = ltrim($matched, '@');
            $normMatched = $this->normalizeUsername($this->removeDiacritics($clean));

            $candidates = $mentionData->filter(fn($d) => $d['norm'] === $normMatched ||
                str_starts_with($d['norm'], $normMatched) ||
                str_starts_with($normMatched, $d['norm'])
            );

            if ($candidates->isEmpty()) {
                $normNoSpace = str_replace(' ', '', $normMatched);
                $candidates = $mentionData->filter(fn($d) => str_replace(' ', '', $d['norm']) === $normNoSpace);
            }

            if ($candidates->isEmpty()) {
                return e($matched);
            }

            $best = $candidates->sortByDesc(fn($d) => mb_strlen($d['norm']))->first();
            $url = $best['url'];

            return '<a href="' . e($url) . '" class="text-primary">' . e($matched) . '</a>';
        }, $escaped);
    }

    private function normalizeUsername(string $name): string
    {
        $s = trim(preg_replace('/\s+/u', ' ', $name));
        $s = mb_strtolower($s);
        if (function_exists('transliterator_transliterate')) {
            $s = transliterator_transliterate('NFD; [:Nonspacing Mark:] Remove; NFC;', $s);
        } else {
            $s = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $s) ?: $s;
        }
        return $s;
    }

    private function removeDiacritics(string $str): string
    {
        if (function_exists('transliterator_transliterate')) {
            return transliterator_transliterate('NFD; [:Nonspacing Mark:] Remove; NFC;', $str);
        }
        return iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $str) ?: $str;
    }
}
