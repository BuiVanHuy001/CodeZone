<?php

namespace App\Livewire\Client\CourseCreation\Components\Builders;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Livewire\Attributes\Modelable;
use Livewire\Component;

class Assignment extends Component
{
	public int $moduleIndex;
	public int $lessonIndex;
	public array $assignment;

	public function removeAssignment(): void
	{
        $this->dispatch('assessment-builders-removed', moduleIndex: $this->moduleIndex, lessonIndex: $this->lessonIndex);
	}

    public function saveAssignment(): void
    {
        if (empty($this->assignment['title']) || empty($this->assignment['description'])) {
            $this->removeAssignment();
        } else {
	        $this->dispatch('assignment-saved',
		        moduleIndex: $this->moduleIndex,
		        lessonIndex: $this->lessonIndex,
		        assignment: $this->assignment
	        );
        }
	}

	public function render(): View|Application|Factory
	{
        return view('livewire.client.course-creation.components.builders.assignment');
	}
}
