<?php

namespace App\Livewire\Client\CourseCreation\Components\Builders\LessonTypes;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Livewire\Attributes\Modelable;
use Livewire\Component;

class Document extends Component
{
    #[Modelable]
    public string $document;

    public function updated(): void
    {
        $this->validate([
            'document' => 'required|string|min:3|max:255',
        ], [
            'document.required' => 'Document is required to identify this document.',
            'document.min' => 'Document must be at least :min characters for clarity.',
            'document.max' => 'Document cannot exceed :max characters to ensure proper display.',
        ]);
    }

    public function render(): View|Application|Factory
    {
        return view('livewire.client.course-creation.components.builders.lesson-types.document');
	}
}
