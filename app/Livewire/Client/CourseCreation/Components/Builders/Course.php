<?php

namespace App\Livewire\Client\CourseCreation\Components\Builders;

use App\Models\Lesson;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Modelable;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Course extends Component {
    #[Modelable]
    public array $modules;
    #[Validate(rule: ['required', 'min:3', 'max:255'], message: [
        'require' => 'Module title is required.',
        'min' => 'Module title must be at least 3 characters.',
        'max' => 'Module title may not be greater than 255 characters.'
    ])]
    public string $newModuleTitle;

    public array $newLesson = [
        'title' => '',
        'description' => '',
        'video_url' => '',
        'content' => '',
        'preview' => false,
        'duration' => 0,
        'type' => ''
    ];

    public array $selectedModule = ['index' => 0];
    public array $activeTabs = [];

    public function updated($propertyName): void
    {
        $this->validateOnly($propertyName);
    }

    public function editModule($index): void
    {
        $this->selectedModule = $this->modules[$index];
        $this->selectedModule['index'] = $index;
    }

    public function addModule(): void
    {
        $this->modules[] = [
            'title' => $this->newModuleTitle,
            'lesson_count' => 1,
            'lessons' => [
                [
                    'title' => '',
                    'video_url' => '',
                    'content' => '',
                    'preview' => false,
                    'type' => '',
                    'duration' => 0
                ]
            ]
        ];
        $this->reset('newModuleTitle');
    }

    public function removeModule(string|int $index): void
    {
        if (count($this->modules) <= 1) {
            $this->dispatch('swal', [
                'title' => 'Minimum Modules Required',
                'text' => 'You must have at least one module in your course.',
                'icon' => 'warning',
            ]);
            return;
        }
        if (isset($this->modules[$index])) {
            unset($this->modules[$index]);
            $this->modules = array_values($this->modules);
            $this->dispatch('swal', [
                'title' => 'Module Removed',
                'text' => 'The module has been successfully removed.',
                'icon' => 'success',
            ]);
        }

    }

    public function addAssessment(): void
    {
        $this->newLesson['assessments'] = [
            'title' => '',
            'description' => '',
            'type' => '',
        ];
    }

    #[On('quiz-questions-imported')]
    public function importQuiz($assessment_questions, int $moduleIndex, int $lessonIndex): void
    {
        $this->modules[$moduleIndex]['lessons'][$lessonIndex]['assessments']['assessments_questions'] = $assessment_questions;
        $this->dispatch('swal', [
            'title' => 'Success',
            'text' => 'Quiz questions imported successfully.',
            'icon' => 'success',
            'timer' => 3000,
            'showConfirmButton' => false
        ]);
    }

    #[On('quiz-saved')]
    public function saveQuiz(int $moduleIndex, int $lessonIndex, $quiz): void
    {
        $this->modules[$moduleIndex]['lessons'][$lessonIndex]['assessments']['title'] = $quiz['title'];
        $this->modules[$moduleIndex]['lessons'][$lessonIndex]['assessments']['description'] = $quiz['description'];
        $this->modules[$moduleIndex]['lessons'][$lessonIndex]['assessments']['assessments_questions'] = $quiz['assessments_questions'];
        $this->activeTabs["$moduleIndex-$lessonIndex"] = '';
    }

    #[On('builders-hided')]
    public function hideAssessmentBuilder(int $moduleIndex, int $lessonIndex): void
    {
        $this->activeTabs["$moduleIndex-$lessonIndex"] = '';
    }

    #[On('assignment-saved')]
    public function saveAssignment(int $moduleIndex, int $lessonIndex, array $assignment): void
    {
        $this->modules[$moduleIndex]['lessons'][$lessonIndex]['assessments']['title'] = $assignment['title'];
        $this->modules[$moduleIndex]['lessons'][$lessonIndex]['assessments']['description'] = $assignment['description'];
        $this->activeTabs["$moduleIndex-$lessonIndex"] = '';
        $this->dispatch('swal', [
            'title' => 'Success',
            'text' => 'Assignment saved successfully.',
            'icon' => 'success',
            'timer' => 3000,
            'showConfirmButton' => false
        ]);
    }

    #[On('assessment-builders-removed')]
    public function removeAssessmentBuilder(int $moduleIndex, int $lessonIndex): void
    {
        unset($this->newLesson['assessments']);
    }

    public function addAssignment(int $moduleIndex, int $lessonIndex): void
    {
        if (
            $this->modules[$moduleIndex]['lessons'][$lessonIndex]['type'] !== 'assessment' ||
            $this->modules[$moduleIndex]['lessons'][$lessonIndex]['assessments']['type'] !== 'assignment'
        ) {
            $this->modules[$moduleIndex]['lessons'][$lessonIndex]['type'] = 'assessment';
            $this->modules[$moduleIndex]['lessons'][$lessonIndex]['assessments'] = [
                'title' => '',
                'description' => '',
                'type' => 'assignment'
            ];
        }
        $this->activeTabs["$moduleIndex-$lessonIndex"] = 'assignment';
    }

    #[On('assignment-removed')]
    public function removeAssignment(int $moduleIndex, int $lessonIndex): void
    {
        if (isset($this->modules[$moduleIndex]['lessons'][$lessonIndex]['assessments'])) {
            $this->modules[$moduleIndex]['lessons'][$lessonIndex]['type'] = '';
            unset($this->modules[$moduleIndex]['lessons'][$lessonIndex]['assessments']);
        }
        $this->activeTabs["$moduleIndex-$lessonIndex"] = '';
    }

    public function addDocument(int $moduleIndex, int $lessonIndex): void
    {
        $this->modules[$moduleIndex]['lessons'][$lessonIndex]['type'] = 'document';
        $this->activeTabs["$moduleIndex-$lessonIndex"] = 'document';
    }

    #[On('document-saved')]
    public function saveDocument(int $moduleIndex, int $lessonIndex, string $document): void
    {
        $this->modules[$moduleIndex]['lessons'][$lessonIndex]['content'] = $document;
        $this->activeTabs["$moduleIndex-$lessonIndex"] = '';
    }

    public function addVideo(int $moduleIndex, int $lessonIndex): void
    {
        if (isset($this->modules[$moduleIndex]['lessons'][$lessonIndex]['assessments'])) {
            unset($this->modules[$moduleIndex]['lessons'][$lessonIndex]['assessments']);
        }
        $this->modules[$moduleIndex]['lessons'][$lessonIndex]['type'] = 'video';
        $this->activeTabs["$moduleIndex-$lessonIndex"] = 'upload-video';
    }

    #[On('video-saved')]
    public function saveVideo(string $videoURL, int $duration): void
    {
        $this->newLesson['video_url'] = $videoURL;
        $this->newLesson['duration'] = $duration;
    }


    #[On('video-deleted')]
    public function deleteVideo(int $moduleIndex, int $lessonIndex): void
    {
        if (isset($this->modules[$moduleIndex]['lessons'][$lessonIndex]['video_url'])) {
            unset($this->modules[$moduleIndex]['lessons'][$lessonIndex]['video_url']);
        }
        if (isset($this->modules[$moduleIndex]['lessons'][$lessonIndex]['duration'])) {
            unset($this->modules[$moduleIndex]['lessons'][$lessonIndex]['duration']);
        }
        $this->activeTabs["$moduleIndex-$lessonIndex"] = '';
    }

    public function addProgrammingPractice(int $moduleIndex, int $lessonIndex): void
    {
        if (
            $this->modules[$moduleIndex]['lessons'][$lessonIndex]['type'] !== 'assessment' ||
            $this->modules[$moduleIndex]['lessons'][$lessonIndex]['assessments']['type'] !== 'programming-practice'
        ) {
            $this->modules[$moduleIndex]['lessons'][$lessonIndex]['type'] = 'assessment';
            $this->modules[$moduleIndex]['lessons'][$lessonIndex]['assessments'] = [
                'title' => '',
                'type' => 'programming',
                'description' => '',
                'problem_details' => [
                    'code_templates' => [],
                    'test_cases' => []
                ],
            ];
        }
        $this->activeTabs["$moduleIndex-$lessonIndex"] = 'programming-practice';
    }

    #[On('programming-practice-saved')]
    public function saveProgrammingPractice(int $moduleIndex, int $lessonIndex, $programmingPractice, $testCases, $codeTemplates, $functionName): void
    {
        $this->modules[$moduleIndex]['lessons'][$lessonIndex]['assessments']['title'] = $programmingPractice['title'];
        $this->modules[$moduleIndex]['lessons'][$lessonIndex]['assessments']['description'] = $programmingPractice['description'];
        $this->modules[$moduleIndex]['lessons'][$lessonIndex]['assessments']['problem_details']['function_name'] = $functionName;
        $this->modules[$moduleIndex]['lessons'][$lessonIndex]['assessments']['problem_details']['code_templates'] = $codeTemplates;
        $this->modules[$moduleIndex]['lessons'][$lessonIndex]['assessments']['problem_details']['test_cases'] = $testCases;
        $this->activeTabs["$moduleIndex-$lessonIndex"] = '';
        $this->dispatch('swal', [
            'title' => 'Success',
            'text' => 'Programming practice saved successfully.',
            'icon' => 'success',
            'timer' => 3000,
            'showConfirmButton' => false
        ]);
    }

    public function addLesson(int $moduleIndex): void
    {
        $this->modules[$moduleIndex]['lesson_count']++;
        $this->modules[$moduleIndex]['lessons'][] = [
            'title' => '',
            'description' => '',
            'video_url' => '',
            'content' => '',
            'preview' => false,
            'duration' => 0,
            'type' => ''
        ];
    }

    public function removeLesson(int $moduleIndex, int $lessonIndex): void
    {
        if (isset($this->modules[$moduleIndex]['lessons'][$lessonIndex])) {
            unset($this->modules[$moduleIndex]['lessons'][$lessonIndex]);
            $this->modules[$moduleIndex]['lessons'] = array_values($this->modules[$moduleIndex]['lessons']);
        }
    }

    public function rules(): array
    {
        return [
            'modules' => 'required|array|min:1',
            'modules.*.title' => [
                'required',
                'min:3',
                'max:255',
                'distinct',
            ],
            'modules.*.lessons' => 'required|array|min:1',
            'modules.*.lessons.*.title' => 'required|min:3|max:255',
            'modules.*.lessons.*.type' => ['required', Rule::in(Lesson::$TYPES)],
            'newLesson.title' => 'required|min:3|max:255',
            'newLesson.type' => 'required|in:' . implode(',', Lesson::$TYPES),
        ];
    }

    public array $messages = [
        'modules.required' => 'At least one module must be created for this course.',
        'modules.*.title.required' => 'Module title is required to identify each learning section.',
        'modules.*.title.distinct' => 'Each module title must be unique within the course.',
        'modules.*.title.min' => 'Module title must be at least :min characters for clarity.',
        'modules.*.title.max' => 'Module title cannot exceed :max characters to ensure proper display.',
        'modules.*.lessons.required' => 'Each module must contain at least one lesson.',
        'modules.*.lessons.*.title.required' => 'Lesson title is required for each learning unit.',
        'modules.*.lessons.*.title.min' => 'Lesson title must be at least :min characters for clarity.',
        'modules.*.lessons.*.title.max' => 'Lesson title cannot exceed :max characters to ensure proper display.',
        'modules.*.lessons.*.type.required' => 'Lesson type must be selected to define the content format.',
        'modules.*.lessons.*.type.in' => 'Please select a valid lesson type from the available options.',
        'newLesson.title.required' => 'Lesson title is required to create a new lesson.',
        'newLesson.title.min' => 'Lesson title must be at least :min characters for clarity.',
        'newLesson.title.max' => 'Lesson title cannot exceed :max characters to ensure proper display.',
        'newLesson.type.required' => 'Lesson type must be selected to define the content format.',
        'newLesson.type.in' => 'Please select a valid lesson type from the available options.',
    ];

    public function render(): Factory|Application|View
    {
        return view('livewire.client.course-creation.components.builders.course');
    }
}
