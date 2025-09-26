<?php

namespace App\Livewire\Client\Review;

use App\Models\Course;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Support\Collection;
use Livewire\Component;
use Livewire\Attributes\On;

class Index extends Component
{
    public Collection $reviews;
    public bool $isReviewAllowed = false;
    public Course $course;

    public function mount(): void
    {
        $this->loadReviews();

        if (auth()->check()) {
            $this->isReviewAllowed = $this->determineReviewPermission();
        }
    }

    private function loadReviews(): void
    {
        $this->reviews = $this->course->reviews()->with('user')->latest()->get();
    }

    private function determineReviewPermission(): bool
    {
        return auth()->user()->isStudent() &&
            auth()->user()->enrollments()->where('course_id', $this->course->id)->exists();
    }

    #[On('review-created')]
    public function refreshReviews(): void
    {
        $this->course->refresh();
        $this->loadReviews();
        if (auth()->check()) {
            $this->isReviewAllowed = $this->determineReviewPermission();
        }
    }

    public function handleReaction(string $type, string|int $reviewId): void
    {
        $review = $this->reviews->firstWhere('id', $reviewId);
        if (!$review) {
            $this->swalError('Something went wrong, please try again later.');
            return;
        }

        $reaction = $review->reactions()->where('user_id', auth()->id())->first();

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
