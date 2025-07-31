<?php

namespace App\Livewire\Client\Lesson\Components\LessonTypes;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Livewire\Component;

class Document extends Component
{
    public string $documentContent;

    public function render(): View|Application|Factory
    {
        return view('livewire.client.lesson.components.lesson-types.document');
    }
}
