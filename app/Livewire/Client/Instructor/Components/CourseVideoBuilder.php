<?php

namespace App\Livewire\Client\Instructor\Components;

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
	public string $tmpVideoPath;
	#[Modelable]
	public $videoURL;

	public int $videoDuration = 0;

	public function updatedVideoURL(): void
	{
		$path = $this->videoURL->storePublicly('course/videos', 'public');
		$publicUrl = Storage::url($path);
		$this->getVideoDuration($path);
		$this->videoURL = $publicUrl;
	}

	public function getVideoDuration(string $path): void
	{
		$absolutePath = storage_path('app/public/' . $path);
		$getID3 = new \getID3;
		$video_file = $getID3->analyze($absolutePath);
		$this->videoDuration = $video_file['playtime_seconds'];
	}

	public function saveVideo(): void
	{
		$this->dispatch('video-saved', moduleIndex: $this->moduleIndex, lessonIndex: $this->lessonIndex, videoDuration: $this->videoDuration);
	}

	public function deleteVideo(): void
	{
		if ($this->videoURL) {
			$relativePath = str_replace('/storage', '', $this->videoURL);
			if (Storage::disk('public')->exists($this->videoURL)) {
				$relativePath = str_replace('course/videos/', 'course/videos/', $relativePath);
			}
			Storage::disk('public')->delete($relativePath);
			File::cleanDirectory(\storage_path('app/private/livewire-tmp'));
			$this->videoURL = null;
		}
		$this->dispatch('video-deleted', moduleIndex: $this->moduleIndex, lessonIndex: $this->lessonIndex);
	}

	public function render(): View|Application|Factory
	{
		return view('livewire.client.instructor.components.course-video-builder');
	}
}
