<?php

namespace App\Livewire\Client\CourseCreation\Components\Builders;

use App\Models\Assessment;
use App\Models\Lesson;
use App\Validator\ModulesBuilderValidate;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Storage;
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

    public array $newLessonAssessments = [
        'title' => '',
        'description' => '',
    ];

    public array $selectedModule = ['index' => 0];

    public function rules(): array
    {
        return ModulesBuilderValidate::rules();
    }

    public array $messages;


    public function mount(): void
    {
        $this->messages = ModulesBuilderValidate::$MESSAGES;
    }

    public function updated($propertyName): void
    {
        $this->validateOnly($propertyName);
    }

    public function updatedNewLessonType(): void
    {
        switch ($this->newLesson['type']) {
        case 'video':
            $this->newLesson['document'] = '';
            $this->newLesson['assessment'] = null;
            break;

        case 'document':
            $this->deleteLessonVideo();
            $this->newLesson['video_file_name'] = '';
            $this->newLesson['duration'] = 0;
            $this->newLesson['assessment'] = null;
            break;

        case 'assessment':
            $this->deleteLessonVideo();
            $this->newLesson['video_file_name'] = '';
            $this->newLesson['duration'] = 0;
            $this->newLesson['document'] = '';

            $this->newLesson['assessment'] = [
                'title' => '',
                'description' => '',
                'type' => '',
            ];
            break;

        default:
            $this->dispatch('lesson-video-deleted');
            $this->newLesson['video_file_name'] = '';
            unset($this->newLesson['tmp_video_file_name']);
            $this->newLesson['duration'] = 0;
            $this->newLesson['document'] = '';
            $this->newLesson['assessments'] = [];
            $this->newLesson['assessment'] = null;
            break;
        }
    }

    private function deleteLessonVideo(): void
    {
        if (empty($this->newLesson['video_file_name']) && empty($this->newLesson['tmp_video_file_name'])) {
            return;
        } else {
            if (empty($this->newLesson['video_file_name'])) {
                $file = storage_path('app/private/livewire-tmp/' . $this->newLesson['tmp_video_file_name']);
            } else {
                $file = storage_path('app/public/course/videos/' . $this->newLesson['video_file_name']);
            }
            if (file_exists($file)) {
                unlink($file);
            }
        }
    }

    #[On('video-saved')]
    public function saveVideo(string $videoFileName, int $duration): void
    {
        $this->newLesson['video_file_name'] = $videoFileName;
        $this->newLesson['duration'] = $duration;
        if (isset($this->newLesson['tmp_video_file_name'])) {
            unset($this->newLesson['tmp_video_file_name']);
        }
    }

    #[On('tmp-video-uploaded')]
    public function tmpVideoUpload(string $tmpVideoFileName): void
    {
        $this->newLesson['tmp_video_file_name'] = $tmpVideoFileName;
    }

    //    public function updatedNewLessonAssessmentsType($value): void
    //    {
    //        $this->newLesson['assessments']['type'] = $value;
    //        $this->newLesson['assessments']['title'] = '';
    //        $this->newLesson['assessments']['description'] = '';
    //        $this->newLesson['assessments']['assessments_questions'] = [];
    //    }

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
        $this->newLesson['assessments'][] = [
            'title' => '',
            'description' => '',
            'type' => null,
            'assessments' => []
        ];
    }

    #[On('assessment-builders-removed')]
    public function removeAssessmentBuilder(): void
    {
        $this->newLesson['assessments'] = [
            'title' => '',
            'description' => '',
            'type' => '',
        ];
    }

    #[On('document-changed')]
    public function documentChange($document): void
    {
        $this->newLesson['document'] = $document;
    }

    public function addLesson(): void
    {
        dd($this->newLesson);
        $this->modules[$this->selectedModule['index']]['lessons'][] = $this->newLesson;
        $this->reset('newLesson');
    }

    public function cancelNewLesson(): void
    {
        if ($this->newLesson['type'] === 'video' && $this->newLesson['video_file_name'] !== '') {
            Storage::disk('public')->delete('course/videos/' . $this->newLesson['video_file_name']);
        }
        $this->reset('newLesson');
        $this->dispatch('lesson-reset');
    }

    public function render(): Factory|Application|View
    {
        return view('livewire.client.course-creation.components.builders.course');
    }
}
