<?php

namespace App\Livewire\Client\CourseCreation\Components\Builders\Lesson\LessonTypes\AssessmentTypes;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Livewire\Attributes\Modelable;
use Livewire\Component;

class Assignment extends Component {
    #[Modelable]
    public array $assignment;

    public bool $showDetails = true;
    public string $unique = '';

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

    public function remove(): void
    {
        if (isset($this->assignment['title'])) {
            $this->dispatch('assessment-deleted', title: $this->assignment['title']);
            $this->reset('assignment');
        }
    }

    public function save(): void
    {
        $this->validate();
        $this->showDetails = false;
        $this->dispatch('assessment-saved');
    }

    public function render(): View|Application|Factory
    {
        return view('livewire.client.course-creation.components.builders.lesson.lesson-types.assessment-types.assignment');
    }
}
