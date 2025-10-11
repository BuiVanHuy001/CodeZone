<?php

namespace App\Services\Review;

use App\Models\Course;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Throwable;

class ReviewService
{
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
        } elseif ($model instanceof User && $model->isInstructor()) {
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
        return Review::query()
            ->where('reviewable_type', Course::class)
            ->whereIn('reviewable_id', $instructor->courses->pluck('id'))
            ->with(['reviewable', 'user'])
            ->latest()
            ->get();
    }

    public function getInstructorReceivedReviews(User $user): Collection
    {
        return $user->reviews()->with(['reviewable', 'user'])->get();
    }

    public function getCourseReviewsByStudent(User $student): Collection
    {
        return Review::query()
            ->where('user_id', $student->id)
            ->where('reviewable_type', Course::class)
            ->with('reviewable')
            ->latest()
            ->get();
    }

    public function getInstructorReviewsByStudent(User $student): Collection
    {
        return Review::query()
            ->where('user_id', $student->id)
            ->where('reviewable_type', User::class)
            ->with('reviewable')
            ->latest()
            ->get();
    }
}
