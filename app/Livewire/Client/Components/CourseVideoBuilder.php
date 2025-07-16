<?php

namespace App\Livewire\Client\Components;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Modelable;
use Livewire\Component;
use Livewire\WithFileUploads;

class CourseVideoBuilder extends Component
{
	use WithFileUploads;

	public int $moduleIndex;
	public int $lessonIndex;
	#[Modelable]
    public $lesson;


    public function updatedLesson(): void
	{
        if ($this->lesson['video_url'] && method_exists($this->lesson['video_url'], 'storePublicly')) {
            $path = $this->lesson['video_url']->storePublicly('course/videos', 'public');
            $publicUrl = Storage::url($path);
            $this->lesson['duration'] = $this->getVideoDuration($path);
            $this->lesson['video_url'] = $publicUrl;
        }
	}

    public function getVideoDuration(string $path): int
	{
		$absolutePath = storage_path('app/public/' . $path);
		$getID3 = new \getID3;
		$video_file = $getID3->analyze($absolutePath);
        return $video_file['playtime_seconds'];
	}

	public function saveVideo(): void
	{
        $this->dispatch('video-saved', moduleIndex: $this->moduleIndex, lessonIndex: $this->lessonIndex);
	}

	public function deleteVideo(): void
	{
        if ($this->lesson['video_url']) {
            $relativePath = str_replace('/storage', '', $this->lesson['video_url']);
            if (Storage::disk('public')->exists($this->lesson['video_url'])) {
				$relativePath = str_replace('course/videos/', 'course/videos/', $relativePath);
			}
			Storage::disk('public')->delete($relativePath);
			File::cleanDirectory(\storage_path('app/private/livewire-tmp'));
            $this->lesson['video_url'] = null;
		}
		$this->dispatch('video-deleted', moduleIndex: $this->moduleIndex, lessonIndex: $this->lessonIndex);
	}

	public function render(): View|Application|Factory
	{
        return view('livewire.client.components.course-video-builder');
	}
}
