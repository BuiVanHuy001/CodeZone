<?php

namespace App\Livewire\Client\Lesson\Components;

use App\Models\Lesson;
use App\Services\Course\LearningService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Livewire\Component;

class LessonNavigator extends Component
{
    public ?string $prevRoute;
    public ?string $nextRoute;
    public ?string $prevId = '';
    public ?string $nextId = '';
    public Lesson $currentLesson;
    private LearningService $courseService;

    public function boot(): void
    {
        $this->courseService = new LearningService();
        $routes = $this->courseService->getNavigationRoutes(
            $this->currentLesson->module->course,
            $this->currentLesson
        );
        $this->prevRoute = $routes['prev'] ?? null;
        $this->nextRoute = $routes['next'] ?? null;
        $this->prevId = $routes['prevId'] ?? null;
        $this->nextId = $routes['nextId'] ?? null;
    }

    public function nextLesson(): void
    {
        if ($this->currentLesson->type === 'assessment') {
            $this->swalWarning('Please complete the assessment before proceeding to the next lesson.');
            return;
        }
        $this->courseService->markLessonComplete($this->currentLesson->id);
        redirect($this->nextRoute);
    }

    public function prevLesson(): void
    {
        redirect($this->prevRoute);
    }

    public function render(): Factory|Application|View
    {
        return view('livewire.client.lesson.components.lesson-navigator');
    }
}
