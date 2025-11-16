<?php

namespace App\Livewire\Admin\Courses;

use App\Services\Admin\Course\CourseService;
use App\Traits\WithSwal;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Courses')]
class Index extends Component {
    use WithSwal;

    private CourseService $adminCourseService;

    public array $courses = [];

    public function boot(): void
    {
        $this->adminCourseService = app(CourseService::class);
        $this->courses = $this->adminCourseService->prepareDataForCourseList();
    }

    public function suspend(string $courseId): void
    {
        $this->loadData();
        if ($this->adminCourseService->suspendCourse($courseId)) {
            $this->swal('The course has been suspended successfully.');
        } else {
            $this->swalError('An error occurred while suspending the course.');
        }
    }

    public function approve(string|int $courseId): void
    {
        $this->loadData();
        if ($this->adminCourseService->approveCourse($courseId)) {
            $this->swal('The course has been approved and published.');
        } else {
            $this->swalError('An error occurred while approving the course.');
        }
    }

    public function reject(string|int $courseId): void
    {
        $this->loadData();
        if ($this->adminCourseService->rejectCourse($courseId)) {
            $this->swal('The course has been rejected.');
        } else {
            $this->swalError('An error occurred while rejecting the course.');
        }
    }

    public function restore(string|int $courseId): void
    {
        $this->loadData();
        if ($this->adminCourseService->restoreCourse($courseId)) {
            $this->swal('The course has been restored successfully.');
        } else {
            $this->swalError('An error occurred while restoring the course.');
        }
    }

    private function loadData(): void
    {
        $this->courses = $this->adminCourseService->prepareDataForCourseList();
        $this->dispatch('course-change');
    }

    public function render(): View
    {
        return view('livewire.admin.courses.index')->layout('components.layouts.admin-dashboard');
    }
}
