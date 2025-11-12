<?php

namespace App\Livewire\Admin\Courses;

use App\Services\Admin\Course\CourseService;
use App\Traits\WithSwal;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Courses')]
class Index extends Component
{
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
        if ($this->adminCourseService->suspendCourse($courseId)) {
            $this->dispatch('course-change');
        } else {
            Log::info('Failed to suspend course', ['course_id' => $courseId]);
        }
    }

    public function approve(string|int $courseId): void
    {
        if ($this->adminCourseService->approveCourse($courseId)) {
            $this->dispatch('course-change');
            $this->swal('The course has been approved and published.');
        } else {
            $this->swalError('An error occurred while approving the course.');
        }
    }

    public function reject(string|int $courseId): void
    {
        if ($this->adminCourseService->rejectCourse($courseId)) {
            $this->dispatch('course-change');
            $this->swal('The course has been rejected.');
        } else {
            $this->swalError('An error occurred while rejecting the course.');
        }
    }

    public function restore(string|int $courseId): void
    {
        if ($this->adminCourseService->restoreCourse($courseId)) {
            $this->dispatch('swalSuccess', '');
        } else {
            $this->swalError('An error occurred while restoring the course.');
        }
    }

    public function render(): View
    {
        return view('livewire.admin.courses.index')->layout('components.layouts.admin-dashboard');
    }
}
