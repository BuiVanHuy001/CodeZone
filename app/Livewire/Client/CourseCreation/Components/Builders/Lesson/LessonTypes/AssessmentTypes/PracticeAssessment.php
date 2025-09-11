<?php

namespace App\Livewire\Client\CourseCreation\Components\Builders\Lesson\LessonTypes\AssessmentTypes;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Livewire\Attributes\Modelable;
use Livewire\Component;

class PracticeAssessment extends Component {
    #[Modelable]
    public array $practiceAssessments;

    public function addPracticeAssessment(): void
    {
        $this->practiceAssessments[] = [
            'title' => '',
            'description' => '',
            'type' => '',
        ];
    }

    public function removePracticeAssessment(string|int $index): void
    {
        unset($this->practiceAssessments[$index]);
        $this->practiceAssessments = array_values($this->practiceAssessments);
    }

    public function render(): Factory|Application|View
    {
        return view('livewire.client.course-creation.components.builders.lesson.lesson-types.assessment-types.practice-assessment');
    }
}
