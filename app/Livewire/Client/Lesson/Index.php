<?php

namespace App\Livewire\Client\Lesson;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\Module;
use App\Models\TrackingProgress;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Livewire\Attributes\On;
use Livewire\Component;

class Index extends Component {
    public Course $course;
    public ?Module $module = null;
    public ?Lesson $lesson = null;
    public string $currentVideo = '';
    public bool $isDisabledNext = false;
    public bool $isDisabledPrevious = false;

    public function mount(): void
    {
        if (!$this->module || !$this->lesson) {
            $this->module = $this->course->modules->sortBy('position')->first();
            $this->lesson = $this->module->lessons->sortBy('position')->first();
            $this->isDisabledPrevious = true;
        };
        if (auth()->user()->isStudent() && !$this->lesson
                ->trackingProgresses()
                ->where('user_id', auth()->user()->id)
                ->exists()) {
            TrackingProgress::create([
                'user_id' => auth()->user()->id,
                'lesson_id' => $this->lesson->id,
            ]);
        }
        $this->currentVideo = $this->lesson->video_url;
    }

    public function previousLesson(): void
    {
        $previousLesson = $this->module->lessons
            ->sortByDesc('position')
            ->where('position', '<', $this->lesson->position)
            ->first();

        if ($previousLesson) {
            $this->lesson = $previousLesson;
        } else {
            $previousModule = $this->course->modules
                ->sortByDesc('position')
                ->where('position', '<', $this->module->position)
                ->first();

            if ($previousModule) {
                $this->module = $previousModule;
                $this->lesson = $this->module->lessons->sortByDesc('position')->first();
            } else {
                $this->isDisabledPrevious = true;
            }
        }

        $this->currentVideo = $this->lesson?->video_url ?? '';
    }

    public function nextLesson(): void
    {
        $nextLesson = $this->module->lessons
            ->sortBy('position')
            ->where('position', '>', $this->lesson->position)
            ->first();

        if ($nextLesson) {
            $this->lesson = $nextLesson;
        } else {
            $nextModule = $this->course->modules
                ->sortBy('position')
                ->where('position', '>', $this->module->position)
                ->first();

            if ($nextModule) {
                $this->module = $nextModule;
                $this->lesson = $this->module->lessons->sortBy('position')->first();
            }
        }

        $this->currentVideo = $this->lesson?->video_url ?? '';
    }

    public function render(): View|Application|Factory
    {
        return view('livewire.client.lesson.index');
    }
}
