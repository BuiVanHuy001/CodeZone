<?php

namespace App\Livewire\Client\Lesson\Components;

use App\Models\Lesson;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Livewire\Component;

class Sidebar extends Component {
    public $modules;
    public string $courseSlug;

    public function checkLessonCompletion(Lesson $lesson): void
    {
        $existingProgress = $lesson
            ->trackingProgresses()
            ->where('user_id', auth()->user()->id)
            ->first();

        if ($existingProgress) {
            $existingProgress->update([
                'is_completed' => !$existingProgress->is_completed
            ]);
        } else {
            $lesson->trackingProgresses()->create([
                'user_id' => auth()->user()->id,
                'is_completed' => true
            ]);
        }
    }

    public function render(): View|Application|Factory
    {
        return view('livewire.client.lesson.components.sidebar');
    }
}
