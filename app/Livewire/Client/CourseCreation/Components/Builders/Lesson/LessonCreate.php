<?php

namespace App\Livewire\Client\CourseCreation\Components\Builders\Lesson;

use App\Traits\HasErrors;
use App\Validator\NewLessonValidator;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Application;
use Illuminate\View\View;
use Livewire\Attributes\Modelable;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

class LessonCreate extends Component {
    use HasErrors;

    #[Validate]
    #[Modelable]
    public array $newLesson = [
        'title' => '',
        'video_file_name' => '',
        'document' => '',
        'preview' => false,
        'duration' => 0,
        'type' => '',
        'assessment' => [],
        'practice_assessments' => []
    ];

    public array $existingLessonTitles = [];

    public array $messages;

    public bool $assessmentValid = false;

    public function mount(): void
    {
        $this->messages = NewLessonValidator::$MESSAGES;
    }

    public function rules(): array
    {
        $rules = NewLessonValidator::rules();

        if (is_string($rules['newLesson.title'])) {
            $rules['newLesson.title'] = explode('|', $rules['newLesson.title']);
        }

        $rules['newLesson.title'][] = function ($attribute, $value, $fail) {
            $incomingTitle = mb_strtolower(trim((string)$value));

            if ($incomingTitle !== '') {
                $normalizedExisting = array_map(
                    fn($t) => mb_strtolower(trim((string)$t)),
                    $this->existingLessonTitles ?? []
                );

                if (in_array($incomingTitle, $normalizedExisting, true)) {
                    $fail('Lesson title must be unique within the module.');
                }
            }
        };

        return $rules;
    }

    public function updated(): void
    {
        $this->validate();
    }

    /**
     * @throws Exception
     */
    public function addLesson(): void
    {
        try {
            if (!empty($this->newLesson['tmp_video_file_name'] ?? null) && empty($this->newLesson['video_file_name'] ?? null)) {
                $this->messages['newLesson.video_file_name.required_if'] = 'You have a temporary uploaded video. Please save it before adding the lesson.';
            }
            $this->validate();

            if (
                ($this->newLesson['type'] ?? null) === 'assessment' &&
                ($this->newLesson['assessment']['type'] ?? null) === 'quiz' &&
                $this->assessmentValid === false
            ) {
                $this->addError('newLesson.assessment', 'Please fix quiz errors before adding the lesson.');
                $this->dispatch('swal', [
                    'title' => 'Invalid Assessment',
                    'html' => 'Please fix assessment errors before adding the lesson.',
                    'icon' => 'error',
                ]);
                return;
            }


            $this->dispatch('lesson-added', newLesson: $this->newLesson);
            $this->dispatch('close-modal', id: 'addLessonModal');

            $this->existingLessonTitles[] = $this->newLesson['title'];

            $this->reset('newLesson');
        } catch (Exception $e) {
            $this->dispatch('swal', [
                'title' => 'Error',
                'html' => 'There was an error adding the lesson: <br>' . $this->prepareRenderErrors($e),
                'icon' => 'error',
            ]);
            throw $e;
        }
    }

    #[On('assessment-updated')]
    public function onAssessmentValid(bool $isValid): void
    {
        $this->assessmentValid = $isValid;
        if ($isValid) {
            $this->resetErrorBag();
            $this->resetValidation();
        } else {
            $this->addError('newLesson.assessment', 'Please fix quiz errors before adding the lesson.');
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

    #[On('video-changed-or-deleted')]
    public function changeOrDeletedVideo(): void
    {
        $this->newLesson['video_file_name'] = '';
        $this->newLesson['duration'] = 0;
    }

    public function render(): Factory|Application|View
    {
        return view('livewire.client.course-creation.components.builders.lesson.lesson-create');
    }
}
