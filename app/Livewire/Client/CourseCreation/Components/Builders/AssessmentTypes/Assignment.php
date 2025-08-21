<?php

namespace App\Livewire\Client\CourseCreation\Components\Builders\AssessmentTypes;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Livewire\Component;

class Assignment extends Component
{
	public int $moduleIndex;
	public int $lessonIndex;
	public array $assignment;

    public function mount()
    {
        $this->assignment = [
            'description' => '',
            'title' => ''
        ];
    }

	public function removeAssignment(): void
	{
        $this->dispatch('assessment-builders-removed');
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
        return view('livewire.client.course-creation.components.builders.assessment-types.assignment');
	}
}
