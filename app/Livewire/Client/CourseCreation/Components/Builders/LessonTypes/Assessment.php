<?php

namespace App\Livewire\Client\CourseCreation\Components\Builders\LessonTypes;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Livewire\Attributes\Modelable;
use Livewire\Component;

class Assessment extends Component {
    #[Modelable]
    public $assessment;

    public function updatedAssessmentType(): void
    {
        unset($this->assessment['assessments_questions']);
    }

    public function render(): Factory|Application|View
    {
        return view('livewire.client.course-creation.components.builders.lesson-types.assessment');
    }
}
