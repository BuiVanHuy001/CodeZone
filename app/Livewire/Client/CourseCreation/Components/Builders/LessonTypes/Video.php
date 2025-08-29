<?php

namespace App\Livewire\Client\CourseCreation\Components\Builders\LessonTypes;

use App\Services\CourseCreation\Builders\LessonTypes\VideoService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Livewire\WithFileUploads;

class Video extends Component {
    use WithFileUploads;

    public $video;
    public ?string $previewVideo = null;
    public ?string $storedVideoAbsPath = null;
    public ?string $storedVideoRelPath = null;
    public int $duration = 0;

    public function updatedVideo(): void
    {
        $this->previewVideo = $this->video->temporaryUrl();
        $this->dispatch('tmp-video-uploaded', tmpVideoFileName: $this->video->getFileName());
        $this->validate([
            'video' => 'required|mimes:mp4,mov,ogg,qt,webm,flv,avi,wmv,mpg|max:256000',
        ], [
            'video.mimes' => 'Please upload a valid video file. Accepted formats: mp4, mov, ogg, qt, webm, flv, avi, wmv, mpg.',
            'video.max' => 'The video file size must not exceed 250MB.',
        ]);
    }

    public function saveVideo(VideoService $videoService): void
    {
        $this->storedVideoRelPath = $this->video->storeAs(
            path: 'course/videos',
            options: 'public',
            name: $this->video->getFileName()
        );

        $this->storedVideoAbsPath = Storage::disk('public')->path($this->storedVideoRelPath);

        $this->duration = $videoService->getDuration($this->storedVideoAbsPath);

        File::delete($this->video->getRealPath());
        $this->reset('previewVideo');

        $this->dispatch('video-saved',
            videoFileName: $this->video->getFileName(),
            duration: $this->duration
        );
    }

    public function changeOrChangeVideo(): void
    {
        if ($this->video) {
            $this->deleteVideo();
        }

        $this->reset('video', 'previewVideo', 'duration', 'storedVideoRelPath', 'storedVideoAbsPath');

        $this->dispatch('video-changed-or-deleted');
    }

    #[On('lesson-video-deleted')]
    public function deletedVideo(): void
    {
        if ($this->video) {
            $this->changeOrChangeVideo();
        }
    }

    private function deleteVideo(): void
    {
        if ($this->video && is_object($this->video) && method_exists($this->video, 'getRealPath')) {
            File::delete($this->video->getRealPath());
        }
        if ($this->storedVideoAbsPath) {
            Storage::disk('public')->delete($this->storedVideoRelPath);
        }
    }

    public function render(): View|Application|Factory
    {
        return view('livewire.client.course-creation.components.builders.lesson-types.video');
    }
}
