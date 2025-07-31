<?php

namespace App\Livewire\Client\Components\Course;

use App\Models\Lesson;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Modelable;
use Livewire\Attributes\On;
use Livewire\Component;

class CourseBuilder extends Component
{
    #[Modelable]
    public array $modules;
    public array $activeTabs = [];

    public function rules(): array
    {
        return [
            'modules' => 'required|array|min:1',
            'modules.*.title' => 'required|min:3|max:255',
            'modules.*.lessons' => 'required|array|min:1',
            'modules.*.lessons.*.title' => 'required|min:3|max:255',
            'modules.*.lessons.*.type' => ['required', Rule::in(Lesson::$TYPES)],
        ];
    }

    public array $messages = [
        'modules.required' => 'At least one module is required.',
        'modules.*.title.required' => 'Module title is required.',
        'modules.*.title.min' => 'Module title must be at least :min characters.',
        'modules.*.title.max' => 'Module title may not be greater than :max characters.',
        'modules.*.lessons.required' => 'At least one lesson is required in each module.',
        'modules.*.lessons.*.title.required' => 'Lesson title is required.',
        'modules.*.lessons.*.title.min' => 'Lesson title must be at least :min characters.',
        'modules.*.lessons.*.title.max' => 'Lesson title may not be greater than :max characters.',
        'modules.*.lessons.*.type.required' => 'Lesson type is required.',
        'modules.*.lessons.*.type.in' => 'Lesson type is invalid.',
    ];

    public function updated($propertyName): void
    {
        $this->validate();
    }

    public function addQuiz(int $moduleIndex, int $lessonIndex): void
    {
        if (
            $this->modules[$moduleIndex]['lessons'][$lessonIndex]['type'] !== 'assessment' ||
            $this->modules[$moduleIndex]['lessons'][$lessonIndex]['assessments']['type'] !== 'quiz'
        ) {
            $this->modules[$moduleIndex]['lessons'][$lessonIndex]['type'] = 'assessment';
            $this->modules[$moduleIndex]['lessons'][$lessonIndex]['assessments'] = [
                'title' => '',
                'description' => '',
                'type' => 'quiz',
                'assessments_questions' => [
                    [
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
                    ]
                ]
            ];
        }
        $this->activeTabs["$moduleIndex-$lessonIndex"] = 'quiz';
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

    #[On('builder-hided')]
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

    #[On('assessment-builder-removed')]
    public function removeAssessmentBuilder(int $moduleIndex, int $lessonIndex): void
    {
        $this->modules[$moduleIndex]['lessons'][$lessonIndex]['type'] = '';
        unset($this->modules[$moduleIndex]['lessons'][$lessonIndex]['assessments']);
        $this->activeTabs["$moduleIndex-$lessonIndex"] = '';
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
    public function saveVideo($moduleIndex, $lessonIndex, string $videoURL, int $duration): void
    {
        $this->modules[$moduleIndex]['lessons'][$lessonIndex]['video_url'] = $videoURL;
        $this->modules[$moduleIndex]['lessons'][$lessonIndex]['duration'] = $duration;

        $this->activeTabs["$moduleIndex-$lessonIndex"] = '';
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

    public function addModule(): void
    {
        $this->modules[] = [
            'title' => '',
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
    }

    public function removeModule(int $index): void
    {
        if (isset($this->modules[$index])) {
            unset($this->modules[$index]);
            $this->modules = array_values($this->modules);
        }
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

    public function render(): Factory|Application|View
    {
        return view('livewire.client.components.course.course-builder');
    }
}
