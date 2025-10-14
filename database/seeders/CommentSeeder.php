<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Course;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

class CommentSeeder extends Seeder
{
    public function run(): void
    {
        $this->generateLessonComment();
    }

    private function generateLessonComment(): void
    {
        $courses = Course::with(['author', 'lessons', 'enrollments'])->get();

        foreach ($courses as $course) {
            $courseAuthor = $course->author->id;
            $students = $course->enrollments()
                ->where('status', 'completed')
                ->pluck('user_id');

            if (!$students->contains($courseAuthor)) {
                $students->push($courseAuthor);
            }

            foreach ($students as $studentId) {
                foreach ($course->lessons as $lesson) {
                    if (fake()->boolean(20)) {
                        $comment = Comment::create([
                            'commentable_id' => $lesson->id,
                            'commentable_type' => get_class($lesson),
                            'user_id' => $studentId,
                            'content' => fake()->paragraph(),
                        ]);

                        if (fake()->boolean(30)) {
                            $this->generateRepliesComment($comment, $students, $courseAuthor);
                        }
                    }
                }
            }
        }
    }

    private function generateRepliesComment(Comment $comment, Collection $students, int|string $courseAuthor): void
    {
        $repliesCount = fake()->numberBetween(1, 3);

        for ($i = 0; $i < $repliesCount; $i++) {
            $userId = fake()->boolean(65)
                ? $courseAuthor
                : $students->random();

            $reply = $this->createCommentWithMention(
                parentComment: $comment,
                userId: $userId,
            );

            if (fake()->boolean(20)) {
                $this->generateRepliesComment($reply, $students, $courseAuthor);
            }
        }
    }

    private function createCommentWithMention(Comment $parentComment, int|string $userId): Comment
    {

        $mentionUser = $parentComment->user;
        $mentionName = $mentionUser->name ?? 'User';

        $comment = Comment::create([
            'commentable_id' => $parentComment->id,
            'commentable_type' => get_class($parentComment),
            'user_id' => $userId,
            'content' => "@{$mentionName} " . fake()->paragraph(),
        ]);

        $comment->mentions()->create([
            'user_id' => $parentComment->user->id,
        ]);

        return $comment;
    }
}
