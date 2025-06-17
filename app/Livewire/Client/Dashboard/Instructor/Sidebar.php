<?php

namespace App\Livewire\Client\Dashboard\Instructor;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Livewire\Component;

class Sidebar extends Component
{
    public $activeComponent;

    public function selectComponent($component): void
    {
        $this->activeComponent = $component;

        $this->emitUp('componentSelected', $component);
    }


    public function render(): Factory|Application|View
    {
        return view('livewire.client.dashboard.instructor.sidebar');
    }
}
