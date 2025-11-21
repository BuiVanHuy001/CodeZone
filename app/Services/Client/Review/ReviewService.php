<?php

namespace App\Services\Client\Review;

use App\Models\Course;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Throwable;

class ReviewService {
    public function store(User $user, Model $model, int $rating, string $content): void
    {
        DB::beginTransaction();
        try {
            Review::create([
                'user_id' => $user->id,
                'rating' => $rating,
                'content' => $content,
                'reviewable_type' => $model->getMorphClass(),
                'reviewable_id' => $model->getKey(),
            ]);
            $this->updateCourseAverageRating($model, $rating);
            DB::commit();
        } catch (Throwable $exception) {
            DB::rollBack();
            throw $exception;
        }
    }

    private function updateCourseAverageRating(Model $model, int $rating): void
    {
        if ($model instanceof Course) {
            $currentRating = $model->rating;
            $currentCount = $model->review_count;
        } elseif ($model instanceof User && $model->hasRole('instructor')) {
            $currentRating = $model->instructorProfile->rating;
            $currentCount = $model->instructorProfile->review_count;
        } else {
            return;
        }

        $model->update([
            'rating' => $this->calculateRating($currentRating, $currentCount, $rating),
            'review_count' => $currentCount,
        ]);
    }

    private function calculateRating(float $currentAverage, float $currentCount, int $newRating): float
    {
        return ($currentAverage * $currentCount + $newRating) / ($currentCount + 1);
    }

    public function getCourseReceivedReviews(User $instructor): Collection
    {
        $cacheKey = "instructor_{$instructor->id}_course_received_reviews";
        return Cache::remember($cacheKey, 86400, function () use ($instructor) {
            return Review::query()
                         ->where('reviewable_type', Course::class)
                         ->whereIn('reviewable_id', $instructor->courses->pluck('id'))
                         ->with(['reviewable', 'user'])
                         ->latest()
                         ->get();
        });
    }

    public function getInstructorReceivedReviews(User $user): Collection
    {
        $cacheKey = "instructor_{$user->id}_received_reviews";
        return Cache::remember($cacheKey, 86400, function () use ($user) {
            return $user->reviews()->with(['reviewable', 'user'])->get();
        });
    }

    public function getCourseReviewsByStudent(User $student): Collection
    {
        $cacheKey = "student_{$student->id}_course_reviews";
        return Cache::remember($cacheKey, 86400, function () use ($student) {
            return Review::query()
                         ->where('user_id', $student->id)
                         ->where('reviewable_type', Course::class)
                         ->with('reviewable')
                         ->latest()
                         ->get();
        });
    }

    public function getInstructorReviewsByStudent(User $student): Collection
    {
        $cacheKey = "student_{$student->id}_instructor_reviews";

        return Cache::remember($cacheKey, 86400, function () use ($student) {
            return Review::query()
                         ->where('user_id', $student->id)
                         ->where('reviewable_type', User::class)
                         ->with('reviewable')
                         ->latest()
                         ->get();
        });
    }
}
