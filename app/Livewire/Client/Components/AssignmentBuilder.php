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
        $this->dispatch('assessment-builder-removed', moduleIndex: $this->moduleIndex, lessonIndex: $this->lessonIndex);
	}

    public function saveAssignment(): void
    {
        if (empty($this->assignment['title']) || empty($this->assignment['description'])) {
            $this->removeAssignment();
        }
        $this->dispatch('builder-hided', moduleIndex: $this->moduleIndex, lessonIndex: $this->lessonIndex);
	}

	public function render(): View|Application|Factory
	{
        return view('livewire.client.components.assignment-builder');
	}
}
