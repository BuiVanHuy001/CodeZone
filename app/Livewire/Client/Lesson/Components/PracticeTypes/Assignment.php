<?php

namespace App\Livewire\Client\Lesson\Components\PracticeTypes;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Livewire\Component;

class Assignment extends Component {
    public function render(): View|Application|Factory
    {
        return view('livewire.client.lesson.components.practice-types.assignment');
    }
}
