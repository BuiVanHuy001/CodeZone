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
    public string $content = '';

	public function saveContent(): void
	{
        $this->dispatch('builder-hided', $this->moduleIndex, $this->lessonIndex);
	}

	public function removeContent(): void
	{
        $this->reset('content');
        $this->dispatch('builder-hided', $this->moduleIndex, $this->lessonIndex);
	}

    public function render(): View|Application|Factory
    {
        return view('livewire.client.components.course-content-builder');
	}
}
