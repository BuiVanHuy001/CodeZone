<?php

namespace App\Livewire\Client\Components;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Livewire\Attributes\Modelable;
use Livewire\Component;

class CourseContentBuilder extends Component
{
	public int $moduleIndex;
	public int $lessonIndex;
	#[Modelable]
	public string $description = '';

	public function saveContent(): void
	{
		$this->dispatch('content-saved', $this->moduleIndex, $this->lessonIndex);
	}

	public function removeContent(): void
	{
		$this->reset('description');
		$this->dispatch('content-removed', $this->moduleIndex, $this->lessonIndex);
	}

    public function render(): View|Application|Factory
    {
        return view('livewire.client.components.course-content-builder');
	}
}
