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
    public bool $showDetail = true;
    #[Modelable]
    public $quiz = [
        'title' => '',
        'description' => '',
        'assessments_questions' => []
    ];

    public function rules(): array
    {
        return [
            'quiz.title' => 'required|string|min:3|max:255',
            'quiz.type' => 'required|in:quiz',
            'quiz.assessments_questions' => 'required|array|min:1',
            'quiz.assessments_questions.*.content' => 'required|string',
            'quiz.assessments_questions.*.type' => [
                'required',
                Rule::in(array_keys(AssessmentQuestion::$TYPES)),
            ],
            'quiz.assessments_questions.*.question_options' => [
                'required',
                'array',
                'min:2',
                function ($attribute, $options, $fail) {
                    if (!collect($options)->contains('is_correct', true)) {
                        $fail('Each question must have at least one correct answer.');
                    }
                },
            ],
            'quiz.assessments_questions.*.question_options.*.content' => 'required|string',
            'quiz.assessments_questions.*.question_options.*.is_correct' => 'required|boolean',
        ];
    }

    public array $messages = [
        'quiz.title.required' => 'Quiz title is required to identify this assessment.',
        'quiz.title.min' => 'Quiz title must be at least :min characters for clarity.',
        'quiz.title.max' => 'Quiz title cannot exceed :max characters to ensure proper display.',
        'quiz.assessments_questions.required' => 'At least one question must be added to create a valid quiz.',
        'quiz.assessments_questions.*.content.required' => 'Question content is required for each quiz question.',
        'quiz.assessments_questions.*.type.required' => 'Question type must be selected for each question.',
        'quiz.assessments_questions.*.question_options.required' => 'At least two answer options are required for each question.',
        'quiz.assessments_questions.*.question_options.*.content.required' => 'Answer option content cannot be empty.',
        'quiz.assessments_questions.*.question_options.*.is_correct.required' => 'Each answer option must be marked as correct or incorrect.',
    ];

    public function mount(): void
    {
        $this->quiz['assessments_questions'] = [];
        $this->quiz['type'] = 'quiz';
    }

    public function updated($propertyName): void
    {
        $this->validateOnly($propertyName);
    }

    public function addOption(int $index): void
    {
        if (!isset($this->quiz['assessments_questions'][$index])) {
            return;
        }
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
            'position' => $optionCount + 1,
            'explanation' => ''
        ];
    }

    public function deleteOption(int $index, int $optionIndex): void
    {
        if (count($this->quiz['assessments_questions'][$index]['question_options']) <= 2) {
            $this->dispatch('swal', [
                'title' => 'Minimum Options Required',
                'text' => 'You must have at least 2 options for each question.',
                'icon' => 'warning',
                'timer' => 3000,
                'showConfirmButton' => false
            ]);
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

    public function removeQuiz(): void
    {
        $this->reset('quiz');
        $this->dispatch('assessment-builders-removed');
    }

    public function saveQuiz(): void
    {
        try {
            $this->validate();
            $this->showDetail = false;
        } catch (ValidationException $e) {
            $this->dispatch('swal', [
                'title' => 'Validation Error',
                'html' => implode('<br>', (array)$e->validator->errors()->all()),
                'icon' => 'error',
            ]);
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
            $this->dispatch('swal', [
                'title' => 'Import Failed',
                'text' => 'There was an error importing the quiz file: ' . implode(', ', (array)$quizImportErrors),
                'icon' => 'error',
            ]);
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

    public function toggleShowDetail(): void
    {
        $this->showDetail = !$this->showDetail;
    }

    public function render(): View|Application|Factory
    {
        return view('livewire.client.course-creation.components.builders.assessment-types.quiz');
    }
}
