<?php

namespace App\Livewire\Admin\Instructor\Components;


use App\DTOs\Course\CourseSummary;
use App\DTOs\Instructor\InstructorDetailDTO;
use App\Models\Course;
use App\Services\Admin\Instructor\InstructorService;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

class InstructorDetail extends Component {
    public ?InstructorDetailDTO $instructor = null;
    public $courses = [];
    public bool $coursesLoaded = false;

    #[On('view-instructor-details')]
    public function loadInstructor($id): void
    {
        $this->courses = [];
        $this->coursesLoaded = false;
        $this->instructor = app(InstructorService::class)->getInstructor($id);
        if ($this->instructor) {
            $this->dispatch('open-details-modal');
        } else {
            $this->swal('Lỗi', 'Không tìm thấy giảng viên', 'warning');
            $this->dispatch('close-details-modal');
        }
    }

    public function loadCourses(): void
    {
        $rawCourses = Course::where('user_id', $this->instructor->id)
                            ->latest()
                            ->limit(10)
                            ->get();

        $this->courses = $rawCourses->map(function ($course) {
            return CourseSummary::fromModel($course);
        })->toArray();
        $this->coursesLoaded = true;
    }

    public function render(): View
    {
        return view('livewire.admin.instructor.components.instructor-detail');
    }
}
