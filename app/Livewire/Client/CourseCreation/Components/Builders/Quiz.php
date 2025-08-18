<?php

namespace App\Livewire\Client\CourseCreation\Components\Builders;

use App\Imports\QuizzesImport;
use App\Services\CourseCreation\Builders\AssessmentTypes\QuizImportService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;

class Quiz extends Component
{
    use WithFileUploads;

    public int $moduleIndex;
    public int $lessonIndex;
    public $excelFile;

    public $quiz;

    public function removeQuiz(): void
    {
        $this->dispatch('assessment-builders-removed',
            moduleIndex: $this->moduleIndex,
            lessonIndex: $this->lessonIndex
        );
    }

    public function addOption(int $index): void
    {
        $optionCount = count($this->quiz['assessments_questions'][$index]['question_options']);
        if ($optionCount >= 4) {
            $this->dispatch('swal', [
                'title' => 'Maximum Options Reached',
                'text' => 'You can only have a maximum of 4 options per question.',
                'icon' => 'warning',
                'timer' => 3000,
                'showConfirmButton' => false
            ]);
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
            $this->dispatch('swal', [
                'title' => 'Minimum Options Required',
                'text' => 'You must have at least one option for each question.',
                'icon' => 'warning',
                'timer' => 3000,
                'showConfirmButton' => false
            ]);
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

    public function updatedExcelFile(QuizImportService $quizImportService): void
    {
        $this->validate(['excelFile' => 'required|file|mimes:xlsx,csv,xls']);
        $results = $quizImportService->importFile($this->excelFile->getRealPath());
        //        $this->importQuestions($import->getParsed());
    }

    private function importQuestions($importedQuestions): void
    {
        if ($this->checkExistingQuestions()) {
            $this->quiz['assessments_questions'] = array_merge($this->quiz['assessments_questions'], $importedQuestions);
        } else {
            $this->quiz['assessments_questions'] = $importedQuestions;
        }

        $this->dispatch('quiz-questions-imported',
            assessment_questions: $this->quiz['assessments_questions'],
            moduleIndex: $this->moduleIndex,
            lessonIndex: $this->lessonIndex
        );
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
        $this->dispatch('quiz-saved',
            moduleIndex: $this->moduleIndex,
            lessonIndex: $this->lessonIndex,
            quiz: $this->quiz,
        );
    }


    public function render(): View|Application|Factory
    {
        return view('livewire.client.course-creation.components.builders.quiz');
    }
}
