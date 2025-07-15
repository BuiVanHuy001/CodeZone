<?php

namespace App\Livewire\Client\Components;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Livewire\Attributes\Modelable;
use Livewire\Component;

class AssignmentBuilder extends Component
{
	public int $moduleIndex;
	public int $lessonIndex;
	#[Modelable]
	public $assignment;

	public function removeAssignment(): void
	{
		$this->dispatch('assignment-removed', moduleIndex: $this->moduleIndex, lessonIndex: $this->lessonIndex);
	}

    public function saveAssignment(): void
    {
		$this->dispatch('assignment-saved', moduleIndex: $this->moduleIndex, lessonIndex: $this->lessonIndex);
	}

	public function render(): View|Application|Factory
	{
        return view('livewire.client.components.assignment-builder');
	}
}
