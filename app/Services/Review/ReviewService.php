<?php

namespace App\Services\Review;

use App\Models\Course;
use App\Models\Review;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Throwable;

class ReviewService
{
    /**
     * @throws Throwable
     */
    public function store(User $user, string|int $courseId, int $rating, string $content): void
    {
        DB::beginTransaction();
        try {
            Review::create([
                'user_id' => $user->id,
                'rating' => $rating,
                'content' => $content,
                'reviewable_type' => 'App\Models\Course',
                'reviewable_id' => $courseId,
            ]);
            $this->updateCourseAverageRating($courseId, $rating);
            DB::commit();
        } catch (Throwable $exception) {
            DB::rollBack();
            throw $exception;
        }
    }

    private function updateCourseAverageRating(string|int $courseId, int $rating): void
    {
        $course = Course::find($courseId);
        $course?->update([
            'rating' => $this->calculateRating(
                $course->rating,
                $course->review_count,
                $rating),
            'review_count' => $course->review_count + 1,
        ]);
    }

    private function calculateRating(float $currentAverage, float $currentCount, int $newRating): float
    {
        return ($currentAverage * $currentCount + $newRating) / ($currentCount + 1);
    }
}
