<?php

namespace App\Livewire\Client\CourseCreation\Components\Builders\Lesson\LessonTypes;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Livewire\Attributes\Modelable;
use Livewire\Attributes\On;
use Livewire\Component;

class Assessment extends Component {
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
        $this->swal($this->assessment['title'] . ' Saved', 'The assessment has been saved successfully.');
    }

    #[On('assessment-deleted')]
    public function assessmentDeleted(string $title): void
    {
        $this->swal($title . ' Deleted', 'The assessment has been deleted successfully.');
    }

    public function render(): Factory|Application|View
    {
        return view('livewire.client.course-creation.components.builders.lesson.lesson-types.assessment');
    }
}
