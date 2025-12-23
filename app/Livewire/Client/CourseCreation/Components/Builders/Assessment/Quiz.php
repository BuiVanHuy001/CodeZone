<?php

namespace App\Livewire\Client\CourseCreation\Components\Builders\Assessment;

use App\Services\Client\Course\Create\Builders\AssessmentTypes\QuizImportService;
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

    public array $editingQuestion = [];
    public int $editingIndex = -1;

    public bool $showDetails = true;
    public array $messages;

    public function rules(): array
    {
        return QuizValidator::rules();
    }

    public function mount(): void
    {
        $this->ensureStructure();
        $this->messages = QuizValidator::$MESSAGES;
    }

    private function ensureStructure(): void
    {
        if (!isset($this->quiz['assessments_questions']) || !is_array($this->quiz['assessments_questions'])) {
            $this->quiz['assessments_questions'] = [];
        }
    }

    public function validateStep1(): true
    {
        $this->validate([
            'quiz.title' => 'required|min:3|max:255',
            'quiz.description' => 'nullable|string',
        ], $this->messages);
        return true;
    }


    public function createQuestion(): void
    {
        $this->ensureStructure();

        $this->editingIndex = -1;
        $this->editingQuestion = [
            'content' => '',
            'type' => 'one_choice',
            'question_options' => [
                ['content' => '', 'is_correct' => false, 'position' => 1, 'explanation' => ''],
                ['content' => '', 'is_correct' => false, 'position' => 2, 'explanation' => '']
            ]
        ];
        $this->dispatch('open-modal', id: 'quizQuestionModal');
    }

    public function editQuestion($index): void
    {
        $this->ensureStructure();

        if (isset($this->quiz['assessments_questions'][$index])) {
            $this->editingIndex = $index;
            $this->editingQuestion = $this->quiz['assessments_questions'][$index];
            $this->dispatch('open-modal', id: 'quizQuestionModal');
        }
    }

    public function saveQuestionFromModal(): void
    {
        $this->ensureStructure();

        if (empty($this->editingQuestion['content'])) {
            $this->swalError('Lỗi', 'Nội dung câu hỏi không được để trống.');
            return;
        }

        if ($this->editingIndex === -1) {
            $this->quiz['assessments_questions'][] = $this->editingQuestion;
        } else {
            if (isset($this->quiz['assessments_questions'][$this->editingIndex])) {
                $this->quiz['assessments_questions'][$this->editingIndex] = $this->editingQuestion;
            } else {
                $this->quiz['assessments_questions'][] = $this->editingQuestion;
            }
        }

        $this->dispatch('close-modal', id: 'quizQuestionModal');
        $this->reset('editingQuestion', 'editingIndex');
    }


    public function addOptionToEditing(): void
    {
        if (!isset($this->editingQuestion['question_options'])) {
            $this->editingQuestion['question_options'] = [];
        }

        if (count($this->editingQuestion['question_options']) >= 4) {
            $this->swalWarning('Giới hạn', 'Tối đa 4 lựa chọn.');
            return;
        }
        $this->editingQuestion['question_options'][] = [
            'content' => '', 'is_correct' => false, 'explanation' => '',
            'position' => count($this->editingQuestion['question_options']) + 1
        ];
    }

    public function deleteOptionFromEditing($index): void
    {
        if (!isset($this->editingQuestion['question_options'])) {
            return;
        }

        if (count($this->editingQuestion['question_options']) <= 2) {
            $this->swalWarning('Cảnh báo', 'Cần tối thiểu 2 lựa chọn.');
            return;
        }
        unset($this->editingQuestion['question_options'][$index]);
        $this->editingQuestion['question_options'] = array_values($this->editingQuestion['question_options']);
    }


    public function deleteQuestion(int $index): void
    {
        $this->ensureStructure();

        if (isset($this->quiz['assessments_questions'][$index])) {
            unset($this->quiz['assessments_questions'][$index]);
            $this->quiz['assessments_questions'] = array_values($this->quiz['assessments_questions']);
        }
    }

    public function saveQuiz(): void
    {
        $this->ensureStructure();
        $this->showDetails = false;
        try {
            $this->validate();
            $this->dispatch('assessment-saved');
            $this->showDetails = false;
            $this->dispatch('assessment-updated', isValid: true);
        } catch (ValidationException $e) {
            $this->dispatch('assessment-updated', isValid: false);
            $this->swalError('Lỗi xác thực', 'Vui lòng kiểm tra lại thông tin.');
            throw $e;
        }
    }

    public function remove(): void
    {
        if (isset($this->quiz['title'])) {
            $this->dispatch('assessment-deleted', title: $this->quiz['title']);
            $this->reset('quiz');
        }
    }

    public function updatedExcelFile(QuizImportService $service): void
    {
        $this->ensureStructure();

        $result = $service->importFile($this->excelFile->getRealPath());
        if (empty($result['errors'])) {
            $this->quiz['assessments_questions'] = array_merge($this->quiz['assessments_questions'], $result['dbQuestions']);
        } else {
            $this->swalError('Lỗi nhập tệp', 'Vui lòng kiểm tra lại file Excel.');
        }
        $this->reset('excelFile');
    }

    public function render(): View|Application|Factory
    {
        return view('livewire.client.course-creation.components.builders.assessment.quiz');
    }
}
