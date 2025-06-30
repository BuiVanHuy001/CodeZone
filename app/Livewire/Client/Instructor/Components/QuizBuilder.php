<?php

namespace App\Livewire\Client\Instructor\Components;

use App\Imports\QuizzesImport;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Livewire\Attributes\Modelable;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;

class QuizBuilder extends Component
{
    use WithFileUploads;
    public string $moduleIndex = '';
    public string $lessonIndex = '';
    public $excelFile;

    #[Modelable]
    public array $quiz;

    public function removeQuiz(): void
    {
        $this->dispatch('quiz-removed', moduleIndex: (int)$this->moduleIndex, lessonIndex: (int)$this->lessonIndex);
    }

    public function addOption(int $index): void
    {
        $optionCount = count($this->quiz['assessments_questions'][$index]['question_options']);
        if ($optionCount >= 4) {
            return;
        }
        $this->quiz['assessments_questions'][$index]['question_options'][] = ['content' => '', 'is_correct' => false, 'position' => count($this->quiz['assessments_questions'][$index]['question_options']) + 1, 'explanation' => '',];
    }

    public function removeOption(int $index, int $optionIndex): void
    {
        if (count($this->quiz['assessments_questions'][$index]['question_options']) <= 1) {
            return;
        }
        unset($this->quiz['assessments_questions'][$index]['question_options'][$optionIndex]);
        $this->quiz['assessments_questions'][$index]['question_options'] = array_values($this->quiz['assessments_questions'][$index]['question_options']);
    }

    public function addQuestion(): void
    {
        $this->quiz['assessments_questions'][] = ['content' => '', 'type' => '', 'question_options' => [['content' => '', 'is_correct' => false, 'explanation' => '', 'position' => 1,],],];
    }

    public function removeQuestion(int $index): void
    {
        if (count($this->quiz['assessments_questions']) <= 1) {
            return;
        }
        unset($this->quiz['assessments_questions'][$index]);
        $this->quiz['assessments_questions'] = array_values($this->quiz['assessments_questions']);
    }

    public function updatedExcelFile(): void
    {
        $this->validate(['excelFile' => 'required|file|mimes:xlsx,csv,xls',]);

        $import = new QuizzesImport();
        Excel::import($import, $this->excelFile);

        $this->quiz['assessments_questions'] = array_merge($this->quiz['assessments_questions'] ?? [], $import->getParsed());

    }


    public function render(): View|Application|Factory
    {
        return view('livewire.client.instructor.components.quiz-builder');
    }
}
