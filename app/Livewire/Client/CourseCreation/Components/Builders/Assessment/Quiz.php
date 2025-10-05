<?php

namespace App\Livewire\Client\CourseCreation\Components\Builders\Assessment;

use App\Services\Course\Create\Builders\AssessmentTypes\QuizImportService;
use App\Traits\WithSwal;
use App\Validator\QuizValidator;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Modelable;
use Livewire\Component;
use Livewire\WithFileUploads;

class Quiz extends Component {
    use WithFileUploads, WithSwal;

    public $excelFile;
    #[Modelable]
    public array $quiz;

    public bool $showDetails = true;

    public array $messages;

    public function rules(): array
    {
        return QuizValidator::rules();
    }

    public function mount(): void
    {
        $this->quiz['assessments_questions'] = [];
        $this->messages = QuizValidator::$MESSAGES;
    }

    public function updated(): void
    {
        try {
            $this->validate();
            $this->dispatch('assessment-updated', isValid: true);
        } catch (ValidationException $e) {
            $this->dispatch('assessment-updated', isValid: false);
            throw $e;
        }
    }


    public function addOption(int $index): void
    {
        if (!isset($this->quiz['assessments_questions'][$index])) {
            return;
        }
        $optionCount = count($this->quiz['assessments_questions'][$index]['question_options']);
        if ($optionCount >= 4) {
            $this->swalWarning('Maximum Options Reached', 'You can only have a maximum of 4 options per question.');
            return;
        }
        $this->quiz['assessments_questions'][$index]['question_options'][] = [
            'content' => '',
            'is_correct' => false,
            'position' => $optionCount + 1,
            'explanation' => ''
        ];
    }

    public function deleteOption(int $index, int $optionIndex): void
    {
        if (count($this->quiz['assessments_questions'][$index]['question_options']) <= 2) {
            $this->swalWarning('Minimum Options Required', 'You must have at least 2 options for each question.');
            return;
        }
        unset($this->quiz['assessments_questions'][$index]['question_options'][$optionIndex]);
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
                ],
                [
                    'content' => '',
                    'is_correct' => false,
                    'explanation' => '',
                    'position' => 2
                ]
            ]
        ];
    }

    public function deleteQuestion(int $index): void
    {
        unset($this->quiz['assessments_questions'][$index]);
    }

    public function remove(): void
    {
        if (isset($this->quiz['title'])) {
            $this->dispatch('assessment-deleted', title: $this->quiz['title']);
            $this->reset('quiz');
        }
    }

    public function saveQuiz(): void
    {
        try {
            $this->validate();
            $this->dispatch('assessment-saved');
            $this->showDetails = false;
            $this->dispatch('assessment-updated', isValid: true);
        } catch (ValidationException $e) {
            $this->dispatch('assessment-updated', isValid: false);
            $this->swalError('Validation Error', 'There was an error saving the quiz:', $e->getMessage());
            throw $e;
        }
    }

    public function updatedExcelFile(QuizImportService $quizImportService): void
    {
        $result = $quizImportService->importFile($this->excelFile->getRealPath());
        $importedQuestions = $result['dbQuestions'];
        $quizImportErrors = $result['errors'];
        $this->reset('excelFile');
        if (empty($quizImportErrors)) {
            $this->importQuestions($importedQuestions);
        } else {
            $this->swalError('Import Failed', 'There was an error importing the quiz file:', $quizImportErrors);
        }
    }

    private function importQuestions($importedQuestions): void
    {
        if ($this->checkExistingQuestions()) {
            $this->quiz['assessments_questions'] = array_merge($this->quiz['assessments_questions'], $importedQuestions);
        } else {
            $this->quiz['assessments_questions'] = $importedQuestions;
        }
        $this->validate();
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

    public function validateStep1(): bool
    {
        $this->validateOnly('quiz.title');
        return true;
    }

    public function render(): View|Application|Factory
    {
        return view('livewire.client.course-creation.components.builders.assessment.quiz');
    }
}
