<?php

namespace App\Livewire\Client\CourseCreation\Components\Builders\Lesson\LessonTypes;

use App\Services\Client\Course\Create\Builders\LessonTypes\VideoService;
use App\Validator\NewLessonValidator;
use Illuminate\Contracts\View\Factory;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithFileUploads;

class Video extends Component {
    use WithFileUploads;

    public $video;

    public ?string $previewVideoUrl = null;
    public ?string $currentFileName = null;

    public int $duration = 0;

    public bool $isDraft = false;
    public bool $isPending = false;
    public bool $hasTempFile = false;

    public array $rules;
    public array $messages;

    public function mount(): void
    {
        $this->rules = NewLessonValidator::rulesForAs('video_file_name', 'video');
        $this->rules['video'] = 'mimes:mp4,mov,webm|max:250000';
        $this->messages = NewLessonValidator::messagesForAs('video_file_name', 'video');

        if (!empty($this->currentFileName)) {
            $this->resolveStoredVideoPath();
        }
    }

    private function resolveStoredVideoPath(): void
    {
        $disk = Storage::disk('public');
        $draftPath = config('filesystems.paths.courses.videos.draft') . '/' . $this->currentFileName;
        $pendingPath = config('filesystems.paths.courses.videos.pending') . '/' . $this->currentFileName;
        $approvedPath = config('filesystems.paths.courses.videos.published') . '/' . $this->currentFileName;

        if ($disk->exists($draftPath)) {
            $this->previewVideoUrl = Storage::url($draftPath);
            $this->isDraft = true;
        } elseif ($disk->exists($pendingPath)) {
            $this->previewVideoUrl = Storage::url($pendingPath);
            $this->isPending = true;
        } elseif ($disk->exists($approvedPath)) {
            $this->previewVideoUrl = Storage::url($approvedPath);
            $this->isPending = false;
        }
    }

    public function updatedVideo(): void
    {
        try {
            $this->validate();

            $this->hasTempFile = true;
            $this->isDraft = false;
            $this->isPending = false;

        } catch (ValidationException $e) {
            $this->reset('video', 'hasTempFile');
            throw $e;
        }
    }

    public function saveVideo(VideoService $videoService): void
    {
        if ($this->video && $this->hasTempFile) {
            $result = $videoService->storeDraftVideo($this->video);

            if ($this->currentFileName) {
                $videoService->destroyVideo($this->currentFileName);
            }

            if ($this->video) {
                $videoService->destroyVideo($this->video);
            }

            $this->currentFileName = $result['videoFileName'];
            $this->duration = $result['duration'];
            $this->previewVideoUrl = $result['storedVideoAbsPath'];

            $this->isDraft = true;
            $this->isPending = false;
            $this->hasTempFile = false;

            $this->reset('video');

            $this->dispatch('video-saved',
                videoFileName: $this->currentFileName,
                duration: $this->duration,
            );
        }
    }

    public function changeOrChangeVideo(VideoService $videoService): void
    {
        if ($this->currentFileName) {
            $videoService->destroyVideo($this->currentFileName);
        }

        if ($this->video) {
            $videoService->destroyVideo($this->video);
        }

        $this->reset('video', 'previewVideoUrl', 'duration', 'currentFileName', 'isDraft', 'isPending', 'hasTempFile');

        $this->dispatch('video-changed-or-deleted');
    }

    public function render(): View|Application|Factory
    {
        return view('livewire.client.course-creation.components.builders.lesson.lesson-types.video');
    }
}
