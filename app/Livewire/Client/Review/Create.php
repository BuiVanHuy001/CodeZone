<?php

namespace App\Livewire\Client\Review;

use App\Models\Course;
use App\Services\Review\ReviewService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Create extends Component
{
    public int $max = 5;
    public ?int $selected = null;
    #[Validate('required|integer|min:1|max:5')]
    public int $rating = 0;
    #[Validate('required|string|max:512')]
    public string $content = '';
    private readonly ReviewService $reviewService;
    public Course $course;

    public function boot(): void
    {
        $this->reviewService = app(ReviewService::class);
    }

    public function mount(Course $course): void
    {
        $this->course = $course;
    }

    public function submitReview(): void
    {
        try {
            $this->validate();
            $this->reviewService->store(
                user: auth()->user(),
                courseId: $this->course->id,
                rating: $this->rating,
                content: $this->content
            );
            $this->reset(['rating', 'content']);
            $this->swal('Success', 'Review submitted successfully.');
            $this->dispatch('review-created');
        } catch (\Throwable $exception) {
            $this->swalError('Error', 'Something went wrong');
        }
    }

    public function render(): View|Application|Factory
    {
        return view('livewire.client.review.create');
    }
}
