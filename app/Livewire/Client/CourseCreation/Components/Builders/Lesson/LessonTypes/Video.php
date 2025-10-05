<?php

namespace App\Livewire\Client\CourseCreation\Components\Builders\Lesson\LessonTypes;

use App\Services\Course\Create\Builders\LessonTypes\VideoService;
use App\Validator\NewLessonValidator;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Livewire\WithFileUploads;

class Video extends Component {
    use WithFileUploads;

    public $video;
    public ?string $previewVideo;
    public ?string $storedVideoAbsPath;
    public ?string $storedVideoRelPath;
    public int $duration = 0;
    public array $rules;
    public array $messages;

    public function mount(): void
    {
        $this->rules = NewLessonValidator::rulesForAs('video_file_name', 'video');
        $this->rules['video'] = 'mimes:mp4,mov,webm';
        $this->messages = NewLessonValidator::messagesForAs('video_file_name', 'video');
        $this->messages['video.mimes'] = 'The video file must be in MP4, MOV, or WEBM format.';

        if (!empty($this->storedVideoRelPath)) {
            $this->storedVideoAbsPath = Storage::url('course/videos/' . $this->storedVideoRelPath);
        } else {
            $this->validate();
        }
    }

    public function updatedVideo(): void
    {
        try {
            $this->validate();

            $this->previewVideo = $this->video->temporaryUrl();
            $this->dispatch('tmp-video-uploaded', tmpVideoFileName: $this->video->getFilename());
        } catch (ValidationException $e) {
            if ($this->video && is_object($this->video) && method_exists($this->video, 'getRealPath')) {
                File::delete($this->video->getRealPath());
            }
            $this->reset('video', 'previewVideo');
            throw $e;
        }
    }

    public function saveVideo(VideoService $videoService): void
    {
        $storedVideoResults = $videoService->storeVideo($this->video);
        $this->reset('previewVideo');

        $this->storedVideoAbsPath = $storedVideoResults['storedVideoAbsPath'];
        $this->storedVideoRelPath = $storedVideoResults['videoFileName'];

        $this->dispatch('video-saved',
            videoFileName: $storedVideoResults['videoFileName'],
            duration: $storedVideoResults['duration'],
        );
    }

    public function changeOrChangeVideo(VideoService $videoService): void
    {
        if ($this->storedVideoRelPath) {
            $videoService->destroyVideo($this->storedVideoRelPath);
        }

        $this->reset('video', 'previewVideo', 'duration', 'storedVideoRelPath', 'storedVideoAbsPath');

        $this->dispatch('video-changed-or-deleted');
    }

    public function render(): View|Application|Factory
    {
        return view('livewire.client.course-creation.components.builders.lesson.lesson-types.video');
    }
}
