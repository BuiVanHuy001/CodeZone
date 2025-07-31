<?php

namespace App\Livewire\Client\Lesson\Components\LessonTypes;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Livewire\Component;

class Video extends Component
{
    public string $videoUrl;

    public function mount(): void
    {
        $this->dispatch('video-changed');
    }

    public function render(): View|Application|Factory
    {
        return view('livewire.client.lesson.components.lesson-types.video');
    }
}
