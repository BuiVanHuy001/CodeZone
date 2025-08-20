<?php

namespace App\Livewire\Client\CourseCreation\Components\Builders\LessonTypes;

use App\Services\CourseCreation\Builders\LessonTypes\VideoService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\File;
use Livewire\Component;
use Livewire\WithFileUploads;

class Video extends Component {
    use WithFileUploads;

    public $video;
    public ?string $previewVideo = null;
    public ?string $storedVideo = null;
    public int $duration = 0;

    public function updatedVideo(): void
    {
        $this->previewVideo = $this->video->temporaryUrl();
        $this->validate([
            'video' => 'required|mimes:mp4,mov,ogg,qt,webm,flv,avi,wmv,mpg|max:256000',
        ], [
            'video.mimes' => 'Please upload a valid video file. Accepted formats: mp4, mov, ogg, qt, webm, flv, avi, wmv, mpg.',
            'video.max' => 'The video file size must not exceed 250MB.',
        ]);
    }

    public function saveVideo(VideoService $videoService): void
    {
        $path = storage_path($this->video->storeAs(
            path: 'course/videos',
            options: 'public',
            name: $this->video->getFileName()
        ));


        $this->duration = $videoService->getDuration($path);
        $this->storedVideo = $path;
        $this->reset('previewVideo');

        File::delete($this->video->getRealPath());

        $this->dispatch('video-saved',
            videoURL: $this->video->getFileName(),
            duration: $this->duration
        );
    }

    public function changeVideo(): void
    {
        if ($this->video) {
            $this->deleteVideo();
        }
        $this->reset('video', 'previewVideo', 'duration');
        $this->dispatch('video-changed');
    }

    public function deleteVideo(): void
    {
        if ($this->previewVideo) {
            File::delete($this->video->getRealPath());
        }
        if ($this->storedVideo) {
            \Storage::delete($this->storedVideo);
        }
    }

    public function render(): View|Application|Factory
    {
        return view('livewire.client.course-creation.components.builders.lesson-types.video');
    }
}
