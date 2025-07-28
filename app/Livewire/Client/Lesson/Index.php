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
            }
        }

        $this->isDisabledPrevious = $this->isFirstLesson();
        $this->isDisabledNext = false;

        $this->dispatch('lessonChanged', route('course.learn', [$this->course->slug, $this->module->id, $this->lesson->id]));
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

        $this->isDisabledNext = $this->isLastLesson();
        $this->isDisabledPrevious = false;

        $this->dispatch('lessonChanged', route('course.learn', [$this->course->slug, $this->module->id, $this->lesson->id]));
    }

    private function isFirstLesson(): bool
    {
        $firstModule = $this->course->modules->sortBy('position')->first();
        $firstLesson = $firstModule?->lessons->sortBy('position')->first();

        return $this->module->id === $firstModule?->id && $this->lesson->id === $firstLesson?->id;
    }

    private function isLastLesson(): bool
    {
        $lastModule = $this->course->modules->sortByDesc('position')->first();
        $lastLesson = $lastModule?->lessons->sortByDesc('position')->first();

        return $this->module->id === $lastModule?->id && $this->lesson->id === $lastLesson?->id;
    }


    public function render(): View|Application|Factory
    {
        return view('livewire.client.lesson.index');
    }
}
