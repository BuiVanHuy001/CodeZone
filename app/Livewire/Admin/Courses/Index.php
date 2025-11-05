<?php

namespace App\Livewire\Admin\Courses;

use App\Services\Admin\Course\CourseService;
use App\Traits\WithSwal;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
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

    public function suspend(string $courseId): void
    {
        $this->courses = $this->adminCourseService->prepareDataForCourseList();
        $this->swalConfirm(
            'suspendCourse',
            $this->getId(),
            parameters: [$courseId],
            text: 'This action will suspend the course.',
            confirmButtonText: 'Yes, suspend it!'
        );
    }

    public function suspendCourse(string $courseId): void
    {
        if ($this->adminCourseService->suspendCourse($courseId)) {
            $this->courses = $this->adminCourseService->prepareDataForCourseList();
            $this->dispatch('course-change');
            $this->swal('The course status has been updated.');
        } else {
            $this->swalError('An error occurred while changing the course status.');
        }
    }

    public function approveCourse(string|int $courseId): void
    {
        $this->courses = $this->adminCourseService->prepareDataForCourseList();
        if ($this->adminCourseService->approveCourse($courseId)) {
            $this->dispatch('course-change');
            $this->swal('The course has been approved and published.');
        } else {
            $this->swalError('An error occurred while approving the course.');
        }
    }

    public function rejectCourse(string|int $courseId): void
    {
        $this->courses = $this->adminCourseService->prepareDataForCourseList();
        if ($this->adminCourseService->rejectCourse($courseId)) {
            $this->dispatch('course-change');
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
