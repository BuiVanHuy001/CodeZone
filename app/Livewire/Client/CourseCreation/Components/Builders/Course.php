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
        'video_file_name' => '',
        'document' => '',
        'preview' => false,
        'duration' => 0,
        'type' => ''
    ];

    public array $selectedModule = ['index' => 0];

    public function updated($propertyName): void
    {
        $this->validateOnly($propertyName);
    }

    public function updatedNewLessonType(): void
    {
        if (!empty($this->newLesson['type'])) {
            if ($this->newLesson['type'] !== 'video') {
                $this->dispatch('lesson-video-deleted');

                $this->newLesson['video_file_name'] = '';
                $this->newLesson['duration'] = 0;
            } elseif ($this->newLesson['type'] !== 'document' && !empty($this->newLesson['document'])) {
                $this->newLesson['document'] = '';
            }
        }
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
                    'video_file_name' => '',
                    'document' => '',
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

    #[On('video-changed-or-deleted')]
    public function changeOrDeletedVideo(): void
    {
        $this->newLesson['video_file_name'] = '';
        $this->newLesson['duration'] = 0;
    }

    public function addAssessment(): void
    {
        $this->newLesson['assessments'] = [
            'title' => '',
            'description' => '',
            'type' => '',
        ];
    }

    #[On('assessment-builders-removed')]
    public function removeAssessmentBuilder(): void
    {
        unset($this->newLesson['assessments']);
    }

    #[On('document-changed')]
    public function documentChange($document): void
    {
        $this->newLesson['document'] = $document;
    }

    #[On('video-saved')]
    public function saveVideo(string $videoFileName, int $duration): void
    {
        $this->newLesson['video_file_name'] = $videoFileName;
        $this->newLesson['duration'] = $duration;
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
