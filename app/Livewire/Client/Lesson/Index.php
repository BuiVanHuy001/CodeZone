<?php

namespace App\Livewire\Client\Lesson;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\Module;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Livewire\Component;

class Index extends Component {
    public Course $course;
    public ?Module $module = null;
    public ?Lesson $lesson = null;
    public string $currentVideo = '';

    public function mount(): void
    {
        if (!$this->module || !$this->lesson) {
            $this->module = $this->course->modules()->first();
            $this->lesson = $this->module->lessons()->first();
        }

        $this->currentVideo = $this->lesson->video_url;
    }

    public function render(): View|Application|Factory
    {
        return view('livewire.client.lesson.index');
    }
}
