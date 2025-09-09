<?php

namespace App\Livewire\Client\CourseCreation\Components\Builders\Lesson;

use App\Traits\HasErrors;
use App\Traits\WithLessonForm;
use App\Validator\NewLessonValidator;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

class LessonCreate extends Component {
    use HasErrors, WithLessonForm;

    #[Validate]
    public array $lesson = [
        'title' => '',
        'video_file_name' => '',
        'document' => '',
        'preview' => false,
        'duration' => 0,
        'type' => '',
        'assessment' => [],
        'practice_assessments' => []
    ];

    public string|int $moduleIndex;

    public array $existingLessonTitles = [];

    public bool $assessmentValid = false;

    public function mount(): void
    {
        $this->mountLessonForm();
    }

    public function updated(): void
    {
        $this->validate();
    }

    #[On('create-lesson')]
    public function receiveData(string|int $moduleIndex): void
    {
        $this->moduleIndex = $moduleIndex;
    }

    /**
     * @throws Exception
     */
    public function addLesson(): void
    {
        try {
            if (!empty($this->lesson['tmp_video_file_name'] ?? null) && empty($this->lesson['video_file_name'] ?? null)) {
                $this->messages['lesson.video_file_name.required_if'] = 'You have a temporary uploaded video. Please save it before adding the lesson.';
            }
            $this->validate();

            if (
                ($this->lesson['type'] ?? null) === 'assessment' &&
                ($this->lesson['assessment']['type'] ?? null) === 'quiz' &&
                $this->assessmentValid === false
            ) {
                $this->addError('lesson.assessment', 'Please fix quiz errors before adding the lesson.');
                $this->dispatch('swal', [
                    'title' => 'Invalid Assessment',
                    'html' => 'Please fix assessment errors before adding the lesson.',
                    'icon' => 'error',
                ]);
                return;
            }

            $this->dispatch('lesson-added', newLesson: $this->lesson, moduleIndex: $this->moduleIndex);
            $this->dispatch('close-modal', id: 'addLesson');

            $this->existingLessonTitles[] = $this->lesson['title'];

            $this->reset('lesson');
        } catch (Exception $e) {
            $this->dispatch('swal', [
                'title' => 'Error',
                'html' => 'There was an error adding the lesson: <br>' . $this->prepareRenderErrors($e),
                'icon' => 'error',
            ]);
            throw $e;
        }
    }

    public function cancel(): void
    {
        if ($this->lesson['type'] === 'video') {
            if (isset($this->lesson['tmp_video_file_name'])) {
                File::delete(storage_path('app/private/livewire-tmp/' . $this->lesson['tmp_video_file_name']));
            } else {
                Storage::disk('public')->delete('course/videos/' . $this->lesson['video_file_name']);
            }
        }
        $this->reset('lesson');
        $this->dispatch('close-modal', id: 'addLesson');
    }

    public function render(): Factory|Application|View
    {
        return view('livewire.client.course-creation.components.builders.lesson.lesson-create');
    }
}
