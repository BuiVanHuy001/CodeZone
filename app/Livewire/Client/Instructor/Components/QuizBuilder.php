<?php

namespace App\Livewire\Client\Instructor\Components;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Livewire\Attributes\Modelable;
use Livewire\Component;
use SweetAlert2\Laravel\Swal;

class QuizBuilder extends Component
{
    public string $moduleIndex = '';
    public string $lessonIndex = '';

    #[Modelable]
    public array $quiz;

    public function removeQuiz()
    {
        $this->dispatch('quiz-removed', moduleIndex: (int)$this->moduleIndex, lessonIndex: (int)$this->lessonIndex);
    }

    public function addOption(int $index): void
    {
        $optionCount = count($this->quiz['assessments_questions'][$index]['question_options']);
        if ($optionCount >= 4) {
            return;
        }
        $this->quiz['assessments_questions'][$index]['question_options'][] = ['content' => '', 'is_correct' => false, 'explanation' => '', 'position' => count($this->quiz['assessments_questions'][$index]['question_options']) + 1,];
    }

    public function removeOption(int $index, int $optionIndex): void
    {
        if (count($this->quiz['assessments_questions'][$index]['question_options']) <= 1) {
            return;
        }
        unset($this->quiz['assessments_questions'][$index]['question_options'][$optionIndex]);
        $this->quiz['assessments_questions'][$index]['question_options'] = array_values($this->quiz['assessments_questions'][$index]['question_options']);
    }

    public function render(): View|Application|Factory
    {
        return view('livewire.client.instructor.components.quiz-builder');
    }
}
