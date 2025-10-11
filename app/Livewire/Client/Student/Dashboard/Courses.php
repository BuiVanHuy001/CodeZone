<?php

namespace App\Livewire\Client\Student\Dashboard;

use App\Services\Course\CatalogService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Support\Collection;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Courses extends Component
{
    public $courses = [];
    public Collection $notStartedCourses;
    public Collection $inProgressCourses;
    public Collection $completedCourses;

    public function mount(): void
    {
        $catalogService = app(CatalogService::class);
        $this->courses = $catalogService->getCoursesByStudent(auth()->user());
        $this->notStartedCourses = $this->courses->where('status', 'not_started');
        $this->inProgressCourses = $this->courses->where('status', 'in_progress');
        $this->completedCourses = $this->courses->where('status', 'completed');
    }

	#[Layout('components.layouts.dashboard')]
    public function render(): View|Application|Factory
    {
        return view('livewire.client.student.dashboard.courses');
    }
}
