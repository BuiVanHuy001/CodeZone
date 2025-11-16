<?php

namespace App\Traits;

use App\Services\Client\Course\Create\Builders\LessonTypes\VideoService;
use App\Validator\NewLessonValidator;
use Livewire\Attributes\On;

trait WithLessonForm {
    public array $messages;
    public bool $assessmentValid = false;
    public array $existingLessonTitles = [];

    public function mountLessonForm(): void
    {
        $this->messages = NewLessonValidator::$MESSAGES;
    }

    public function rules(): array
    {
        return NewLessonValidator::rules($this->existingLessonTitles);
    }

    public function updatedLessonType(VideoService $videoService): void
    {
        switch ($this->lesson['type']) {
        case 'video':
            $this->lesson['document'] = '';
            $this->lesson['assessment'] = null;
            break;

        case 'document':
            $this->deleteLessonVideo($videoService);
            $this->lesson['video_file_name'] = '';
            $this->lesson['duration'] = 0;
            $this->lesson['assessment'] = null;
            break;

        case 'assessment':
            $this->deleteLessonVideo($videoService);
            $this->lesson['video_file_name'] = '';
            $this->lesson['duration'] = 0;
            $this->lesson['document'] = '';
            $this->lesson['assessment'] = [];
            break;

        default:
            $this->deleteLessonVideo($videoService);
            $this->lesson['video_file_name'] = '';
            unset($this->lesson['tmp_video_file_name']);
            $this->lesson['duration'] = 0;
            $this->lesson['document'] = '';
            unset($this->lesson['assessment']);
            break;
        }
    }

    private function deleteLessonVideo(VideoService $videoService): void
    {
        if (empty($this->lesson['video_file_name']) && empty($this->lesson['tmp_video_file_name'])) {
            return;
        }

        $filename = !empty($this->lesson['tmp_video_file_name'])
            ? $this->lesson['tmp_video_file_name']
            : ($this->lesson['video_file_name'] ?? '');

        $videoService->destroyVideo($filename);
    }

    #[On('assessment-updated')]
    public function onAssessmentValid(bool $isValid): void
    {
        $this->assessmentValid = $isValid;
        if ($isValid) {
            $this->resetErrorBag();
            $this->resetValidation();
        } else {
            $this->addError('lesson.assessment', 'Please fix quiz errors before adding the lesson.');
        }
    }

    #[On('video-saved')]
    public function setVideo(string $videoFileName, int $duration): void
    {
        $this->lesson['video_file_name'] = $videoFileName;
        $this->lesson['duration'] = $duration;
        if (isset($this->lesson['tmp_video_file_name'])) {
            unset($this->lesson['tmp_video_file_name']);
        }
    }

    #[On('tmp-video-uploaded')]
    public function setTmpVideo(string $tmpVideoFileName): void
    {
        $this->lesson['tmp_video_file_name'] = $tmpVideoFileName;
    }

    #[On('video-changed-or-deleted')]
    public function unsetVideo(): void
    {
        $this->lesson['video_file_name'] = '';
        $this->lesson['duration'] = 0;
    }
}
