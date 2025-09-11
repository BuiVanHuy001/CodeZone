<?php

namespace App\Livewire\Client\CourseCreation\Components\Builders\Lesson\LessonTypes;

use App\Validator\NewLessonValidator;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Livewire\Attributes\Modelable;
use Livewire\Component;

class Document extends Component {
    #[Modelable]
    public string $document = '';
    public array $messages;
    public array $rules;

    public function mount(): void
    {
        $this->messages = NewLessonValidator::messagesFor('document');
        $this->rules = NewLessonValidator::rulesFor('document');
    }

    public function updated(): void
    {
        $this->validate();
    }

    public function render(): View|Application|Factory
    {
        return view('livewire.client.course-creation.components.builders.lesson.lesson-types.document');
    }
}
