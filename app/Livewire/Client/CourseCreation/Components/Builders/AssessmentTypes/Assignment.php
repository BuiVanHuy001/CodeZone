<?php

namespace App\Livewire\Client\CourseCreation\Components\Builders\AssessmentTypes;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Livewire\Attributes\Modelable;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Assignment extends Component {
    #[Modelable]
    public array $assignment;

    public bool $showDetail = true;

    public function rules(): array
    {
        return [
            'assignment.title' => 'required|min:3|max:255',
            'assignment.description' => 'required',
        ];
    }

    public function updated($propertyName): void
    {
        $this->validateOnly($propertyName);
    }

    public function removeAssignment(): void
    {
        $this->dispatch('assessment-builders-removed');
    }

    public function saveAssignment(): void
    {
        $this->validate();
        $this->showDetail = false;
    }

    public function toggleShowDetail(): void
    {
        $this->showDetail = !$this->showDetail;
    }

    public function render(): View|Application|Factory
    {
        return view('livewire.client.course-creation.components.builders.assessment-types.assignment');
    }
}
