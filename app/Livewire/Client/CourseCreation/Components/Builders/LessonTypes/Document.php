<?php

namespace App\Livewire\Client\CourseCreation\Components\Builders\LessonTypes;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Livewire\Component;

class Document extends Component {
    public function render(): View|Application|Factory
    {
        return view('livewire.client.course-creation.components.builders.lesson-types.document');
    }
}
