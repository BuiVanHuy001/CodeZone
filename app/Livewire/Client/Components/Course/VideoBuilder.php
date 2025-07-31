<?php

namespace App\Livewire\Client\Components\Course;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Modelable;
use Livewire\Component;
use Livewire\WithFileUploads;

class VideoBuilder extends Component
{
	use WithFileUploads;

	public int $moduleIndex;
	public int $lessonIndex;
	public $videoURL;
	public int $duration = 0;


	public function updated(): void
	{
		if ($this->videoURL && method_exists($this->videoURL, 'storePublicly')) {
			$path = $this->videoURL->storePublicly('course/videos', 'public');
            $publicUrl = Storage::url($path);
			$this->duration = $this->getVideoDuration($path);
			$this->videoURL = $publicUrl;
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
		$this->dispatch('video-saved',
			moduleIndex: $this->moduleIndex,
			lessonIndex: $this->lessonIndex,
			videoURL: $this->videoURL,
			duration: $this->duration
		);
	}


	public function deleteVideo(): void
	{
		if ($this->video) {
			$relativePath = str_replace('/storage', '', $this->video);
			if (Storage::disk('public')->exists($this->video)) {
				$relativePath = str_replace('course/videos/', 'course/videos/', $relativePath);
			}
			Storage::disk('public')->delete($relativePath);
			File::cleanDirectory(\storage_path('app/private/livewire-tmp'));
			$this->videoURL = null;
		}
		$this->dispatch('video-deleted', $this->moduleIndex, $this->lessonIndex);
	}

	public function render(): View|Application|Factory
	{
		return view('livewire.client.components.course.video-builder');
	}
}
