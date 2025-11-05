<?php

namespace App\Livewire\Admin\Courses;

use App\Services\Admin\Course\CourseService;
use App\Traits\WithSwal;
use Illuminate\Contracts\View\View;
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
    }

    public function mount(): void
    {
        $this->courses = $this->adminCourseService->prepareDataForCourseList();
    }

    public function approve(string|int $courseId): void
    {
        $this->courses = $this->adminCourseService->prepareDataForCourseList();
        $this->swalConfirm(
            'approveCourse',
            $this->getId(),
            parameters: [$courseId],
            text: 'This action will publish the course and notify the author.',
            confirmButtonText: 'Yes, approve it!'
        );
    }

    public function reject(string|int $courseId): void
    {
        $this->courses = $this->adminCourseService->prepareDataForCourseList();
        $this->swalConfirm(
            'rejectCourse',
            $this->getId(),
            parameters: [$courseId],
            text: 'This action will reject the course submission.',
            confirmButtonText: 'Yes, reject it!'
        );
    }

    public function approveCourse(string|int $courseId): void
    {
        if ($this->adminCourseService->approveCourse($courseId)) {
            $this->courses = $this->adminCourseService->prepareDataForCourseList();
            $this->dispatch('course-approved', courseId: $courseId);
            $this->swal('The course has been approved and published.');
        } else {
            $this->swalError('An error occurred while approving the course.');
        }
    }

    public function rejectCourse(string|int $courseId): void
    {
        if ($this->adminCourseService->rejectCourse($courseId)) {
            $this->courses = $this->adminCourseService->prepareDataForCourseList();
            $this->dispatch('course-rejected', courseId: $courseId);
            $this->swal('The course has been rejected.');
        } else {
            $this->swalError('An error occurred while rejecting the course.');
        }
    }

    public function render(): View
    {
        return view('livewire.admin.courses.index')->layout('components.layouts.admin-dashboard');
    }
}
