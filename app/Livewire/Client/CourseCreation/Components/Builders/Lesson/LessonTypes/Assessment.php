<?php

namespace App\Livewire\Client\CourseCreation\Components\Builders\Lesson\LessonTypes;

use App\Traits\WithSwal;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Livewire\Attributes\Modelable;
use Livewire\Attributes\On;
use Livewire\Component;

class Assessment extends Component {
    use WithSwal;

    #[Modelable]
    public array $assessment = [
        'title' => '',
        'description' => '',
        'type' => '',
    ];

    public function updatedAssessmentType(): void
    {
        unset($this->assessment['assessments_questions']);
    }

    #[On('assessment-saved')]
    public function assessmentSaved(): void
    {
        $this->swal('Đã lưu ' . $this->assessment['title'], 'Thông tin đánh giá đã được lưu thành công.');
    }

    #[On('assessment-deleted')]
    public function assessmentDeleted(string $title): void
    {
        $this->swal('Đã xóa ' . $title, 'Thông tin đánh giá đã được xóa thành công.');
    }

    public function render(): Factory|Application|View
    {
        return view('livewire.client.course-creation.components.builders.lesson.lesson-types.assessment');
    }
}
