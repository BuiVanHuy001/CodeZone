<?php

namespace App\Livewire\Client\Instructor\Components;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Livewire\Component;

class Sidebar extends Component {
    public function render(): View|Application|Factory
    {
        return view('livewire.client.instructor.components.sidebar');
    }
}
