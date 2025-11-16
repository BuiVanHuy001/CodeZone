<?php

namespace App\Livewire\Client\Student\Dashboard;

use App\Services\Client\Review\ReviewService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Support\Collection;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Reviews extends Component
{
    public Collection $courseReviews;
    public Collection $instructorReviews;

    public function mount(ReviewService $reviewService): void
    {
        $this->courseReviews = $reviewService->getCourseReviewsByStudent(auth()->user());
        $this->instructorReviews = $reviewService->getInstructorReviewsByStudent(auth()->user());
    }

    #[Layout('components.layouts.dashboard')]
    public function render(): View|Application|Factory
    {
        return view('livewire.client.student.dashboard.reviews');
    }
}
