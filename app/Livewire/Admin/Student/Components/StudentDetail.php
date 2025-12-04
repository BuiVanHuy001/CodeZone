<?php

namespace App\Livewire\Admin\Student\Components;

use App\DTOs\Course\CourseSummary;
use App\DTOs\Student\StudentDetailDTO;
use App\Models\User;
use App\Services\Admin\Student\StudentService;
use App\Services\Client\Course\LearningService;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

class StudentDetail extends Component {
    public ?StudentDetailDTO $student = null;

    public array $courses = [];
    public bool $coursesLoaded = false;

    protected StudentService $studentService;

    public function boot(StudentService $studentService): void
    {
        $this->studentService = $studentService;
    }

    #[On('view-student-detail')]
    public function loadStudent(string $id): void
    {
        $this->courses = [];
        $this->coursesLoaded = false;

        $this->student = $this->studentService->getStudentDetail($id);

        if ($this->student) {
            $this->dispatch('open-modal', id: 'studentDetailModal');
        } else {
            $this->dispatch('alert', type: 'error', message: 'Không tìm thấy sinh viên');
            $this->dispatch('close-modal', id: 'studentDetailModal');
        }
    }

    public function loadCourses(): void
    {
        if (!$this->student) return;

        $userModel = User::find($this->student->id);

        if (!$userModel) return;

        $coursesWithProgress = app(LearningService::class)->getStudentCoursesProgress($userModel);

        $this->courses = $coursesWithProgress
            ->sortByDesc('progressPercentage')
            ->map(function ($course) {
                return CourseSummary::fromModel(
                    $course,
                    includeAuthor: true,
                    progress: $course->progressPercentage ?? 0,
                    enrollmentStatus: $course->enrollmentStatus ?? 'unknown'
                );
            })
            ->toArray();

        $this->coursesLoaded = true;
    }

    public function render(): View
    {
        return view('livewire.admin.student.components.student-detail');
    }
}
