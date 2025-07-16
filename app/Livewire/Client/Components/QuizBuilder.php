<?php

namespace App\Livewire\Client\Components;

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

    public int $moduleIndex;
    public int $lessonIndex;
    public $excelFile;

    #[Modelable]
    public $quiz;

    public function removeQuiz(): void
    {
        $this->dispatch('assessment-builder-removed', moduleIndex: $this->moduleIndex, lessonIndex: $this->lessonIndex);
    }

    public function addOption(int $index): void
    {
        $optionCount = count($this->quiz['assessments_questions'][$index]['question_options']);
        if ($optionCount >= 4) {
            return;
        }
	    $this->quiz['assessments_questions'][$index]['question_options'][] = [
		    'content' => '',
		    'is_correct' => false,
		    'position' => count($this->quiz['assessments_questions'][$index]['question_options']) + 1,
		    'explanation' => ''
	    ];
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
	    $this->quiz['assessments_questions'][] = [
		    'content' => '',
		    'type' => '',
		    'question_options' => [
			    [
				    'content' => '',
				    'is_correct' => false,
				    'explanation' => '',
				    'position' => 1
			    ]
		    ]
	    ];
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
        $this->validate(['excelFile' => 'required|file|mimes:xlsx,csv,xls']);
        $import = new QuizzesImport();
        Excel::import($import, $this->excelFile);

        $this->importQuestions($import->getParsed());

        $this->saveQuiz();
    }

    private function importQuestions($importedQuestions): void
    {
        if ($this->checkExistingQuestions()) {
            $this->quiz['assessments_questions'] = array_merge($this->quiz['assessments_questions'], $importedQuestions);
        } else {
            $this->quiz['assessments_questions'] = $importedQuestions;
        }
    }

    private function checkExistingQuestions(): bool
    {
        if (isset($this->quiz['assessments_questions']) && is_array($this->quiz['assessments_questions'])) {
            foreach ($this->quiz['assessments_questions'] as $question) {
                if (isset($question['content']) && !empty(trim($question['content']))) {
                    return true;
                }
            }
        }
        return false;
    }

    public function saveQuiz(): void
    {
        $this->dispatch('builder-hided', moduleIndex: $this->moduleIndex, lessonIndex: $this->lessonIndex);
    }


    public function render(): View|Application|Factory
    {
        return view('livewire.client.components.quiz-builder');
    }
}
