<?php

namespace App\Livewire\Client\Lesson\Components;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Livewire\Component;

class Sidebar extends Component {
    public $modules;
    public string $courseSlug;

    public function _mount($modules, $courseSlug): void
    {
        $this->modules = $modules;
        $this->courseSlug = $courseSlug;
    }

    public function render(): View|Application|Factory
    {
        return view('livewire.client.lesson.components.sidebar');
    }
}
