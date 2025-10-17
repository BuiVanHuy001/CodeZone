<?php

namespace App\Livewire\Client\Instructor\Dashboard;

use App\Services\Instructor\InstructorService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('My Dashboard')]
class Overview extends Component
{
    public string $publishedCourses;
    public string $totalEarnings;
    public string $studentsEnrolled;
    public string $rating;
    public string $reviewCount;

    public function mount(InstructorService $instructorService): void
    {
        $data = $instructorService->prepareOverviewData(auth()->user());

        $this->publishedCourses = $data['publishedCourses'];
        $this->totalEarnings = $data['totalEarnings'];
        $this->studentsEnrolled = $data['studentsEnrolled'];
        $this->rating = $data['rating'];
        $this->reviewCount = $data['reviewCount'];
    }

	#[Layout('components.layouts.dashboard')]
    public function render(): View|Application|Factory
    {
	    return view('livewire.client.instructor.dashboard.overview');
    }
}
