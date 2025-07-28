<?php

namespace App\Livewire\Client\Lesson\Components\AssessmentTypes;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Livewire\Component;

class ProgrammingPractice extends Component
{
    public function render(): View|Application|Factory
    {
        return view('livewire.client.lesson.components.assessment-types.programming-practice');
    }
}
