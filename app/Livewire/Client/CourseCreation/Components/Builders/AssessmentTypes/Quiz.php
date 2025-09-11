<?php

namespace App\Livewire\Client\CourseCreation\Components\Builders\AssessmentTypes;

use App\Models\AssessmentQuestion;
use App\Services\CourseCreation\Builders\AssessmentTypes\QuizImportService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Modelable;
use Livewire\Component;
use Livewire\WithFileUploads;

class Quiz extends Component {
    use WithFileUploads;

    public $excelFile;
    public bool $isErrors = true;

    #[Modelable]
    public $quiz;

    public function rules(): array
    {
        return [
            'quiz.title' => 'required|string|min:3|max:255',
            'quiz.description' => 'nullable|string',
            'quiz.type' => 'required|in:quiz',
            'quiz.assessments_questions' => 'required|array|min:1',
            'quiz.assessments_questions.*.content' => 'required|string',
            'quiz.assessments_questions.*.type' => ['required', Rule::in(AssessmentQuestion::$TYPES)],
            'quiz.assessments_questions.*.question_options' => 'required|array|min:2',
            'quiz.assessments_questions.*.question_options.*.content' => 'required|string',
            'quiz.assessments_questions.*.question_options.*.is_correct' => 'required|boolean',
            'quiz.assessments_questions.*.question_options.*.explanation' => 'nullable|string'
        ];
    }

    public array $messages = [
        'quiz.title.required' => 'Quiz title is required to identify this assessment.',
        'quiz.title.min' => 'Quiz title must be at least :min characters for clarity.',
        'quiz.title.max' => 'Quiz title cannot exceed :max characters to ensure proper display.',
        'quiz.description.max' => 'Quiz description cannot exceed :max characters.',
        'quiz.assessments_questions.required' => 'At least one question must be added to create a valid quiz.',
        'quiz.assessments_questions.*.content.required' => 'Question content is required for each quiz question.',
        'quiz.assessments_questions.*.type.required' => 'Question type must be selected for each question.',
        'quiz.assessments_questions.*.question_options.required' => 'At least two answer options are required for each question.',
        'quiz.assessments_questions.*.question_options.*.content.required' => 'Answer option content cannot be empty.',
        'quiz.assessments_questions.*.question_options.*.is_correct.required' => 'Each answer option must be marked as correct or incorrect.',
    ];

    public function updated($propertyName): void
    {
        try {
            $this->validateOnly($propertyName);
            $this->isErrors = false;
        } catch (ValidationException $e) {
            $this->isErrors = true;
            throw $e;
        }
    }

    public function mount(): void
    {
        $this->quiz['assessments_questions'] = [];
    }

    public function removeQuiz(): void
    {
        $this->reset('quiz');

        $this->dispatch('assessment-builders-removed');
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
        return view('livewire.client.course-creation.components.builders.assessment-types.quiz');
    }
}
