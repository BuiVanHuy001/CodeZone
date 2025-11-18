<?php

namespace App\Livewire\Client\Instructor\Dashboard;

use App\Services\Client\Instructor\InstructorService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Support\Collection;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('My Courses')]
class Courses extends Component
{
    public Collection $allCourses;
    public Collection $publicCourses;
    public Collection $pendingCourses;
    public Collection $draftCourses;
    public Collection $rejectedCourses;

    public function mount(): void
    {
        $this->allCourses = app(InstructorService::class)->getInstructorCourses(auth()->user());
        $this->publicCourses = $this->allCourses->where('status', 'published')->values();
        $this->pendingCourses = $this->allCourses->where('status', 'pending')->values();
        $this->draftCourses = $this->allCourses->where('status', 'draft')->values();
        $this->rejectedCourses = $this->allCourses->where('status', 'rejected')->values();
    }

    public function editCourse(): void
    {
        $this->dispatch('swal', [
            'icon' => 'info',
            'title' => 'Ops, Sorry!',
            'text' => 'Course editing functionality is not implemented yet.',
        ]);
    }

    #[Layout('components.layouts.dashboard')]
    public function render(): View|Application|Factory
    {
        return view('livewire.client.instructor.dashboard.courses');
    }
}
