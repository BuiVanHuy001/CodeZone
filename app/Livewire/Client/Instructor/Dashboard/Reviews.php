<?php

namespace App\Livewire\Client\Instructor\Dashboard;

use App\Services\Review\ReviewService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Support\Collection;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('My Reviews')]
class Reviews extends Component
{
    public Collection $reviewInstructor;
    public Collection $reviewCourses;

    public function mount(ReviewService $reviewInstructor): void
    {
        $this->reviewInstructor = $reviewInstructor->getInstructorReceivedReviews(auth()->user());
        $this->reviewCourses = $reviewInstructor->getCourseReceivedReviews(auth()->user());
    }

	#[Layout('components.layouts.dashboard')]
    public function render(): View|Application|Factory
    {
	    return view('livewire.client.instructor.dashboard.reviews');
    }
}
