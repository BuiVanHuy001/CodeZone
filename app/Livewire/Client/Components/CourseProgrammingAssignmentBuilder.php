<?php

namespace App\Livewire\Client\Components;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Livewire\Attributes\Modelable;
use Livewire\Component;

class CourseProgrammingAssignmentBuilder extends Component {
    public $moduleIndex;
    public $lessonIndex;

    #[Modelable]
    public $lesson;


    public function render(): Factory|Application|View
    {
        return view('livewire.client.components.course-programming-assignment-builder');
    }
}
