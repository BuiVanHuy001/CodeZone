<?php

namespace App\Livewire\Client\Review;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Application;
use Illuminate\Support\Collection;
use Livewire\Component;
use Livewire\Attributes\On;

class Index extends Component
{
    public Collection $reviews;
    public bool $canReview = false;
    public Model $model;

    public function mount(): void
    {
        $this->loadReviews();

        if (auth()->check()) {
            $this->canReview = $this->determineReviewPermission();
        }
    }

    private function loadReviews(): void
    {
        $this->reviews = $this->model->reviews()->with('user')->latest()->get();
    }

    private function determineReviewPermission(): bool
    {
        $user = auth()->user();

        if (!$user->hasRole('student')) {
            return false;
        }

        $hasEnrolled = false;
        $modelType = get_class($this->model);

        if ($modelType === 'App\Models\Course') {
            $hasEnrolled = $user->enrollments()->where('course_id', $this->model->id)->exists();
        } elseif ($modelType === 'App\Models\User' && $this->model->hasRole('instructor')) {
            $hasEnrolled = $user->enrollments()
                ->whereHas('course', function ($query) {
                    $query->where('user_id', $this->model->id);
                })
                ->exists();
        }

        $hasReviewed = $this->model->reviews()->where('user_id', $user->id)->exists();

        return $hasEnrolled && !$hasReviewed;
    }

    #[On('review-created')]
    public function refreshReviews(): void
    {
        $this->model->refresh();
        $this->loadReviews();
        if (auth()->check()) {
            $this->canReview = $this->determineReviewPermission();
        }
    }

    public function handleReaction(string $type, string|int $reviewId): void
    {
        $review = $this->reviews->firstWhere('id', $reviewId);
        if (!$review) {
            $this->swalError('Something went wrong, please try again later.');
            return;
        }

        $reaction = $review->reactions->where('user_id', auth()->id())->first();

        if ($reaction) {
            if ($reaction->type === $type) {
                $reaction->delete();
            } else {
                $reaction->update(['type' => $type]);
            }
        } else {
            $review->reactions()->create([
                'user_id' => auth()->id(),
                'type' => $type,
            ]);
        }
    }

    public function render(): View|Application|Factory
    {
        return view('livewire.client.review.index');
    }
}
