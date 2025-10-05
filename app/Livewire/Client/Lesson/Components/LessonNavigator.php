<?php

namespace App\Livewire\Client\Lesson\Components;

use App\Models\Lesson;
use App\Services\Course\LearningService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Livewire\Component;
use App\Models\AssessmentAttempt;

class LessonNavigator extends Component
{
    public ?string $prevRoute;
    public ?string $nextRoute;
    public ?string $prevId = '';
    public ?string $nextId = '';
    public Lesson $currentLesson;
    private LearningService $courseService;
    public bool $isCompleted = false;

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
        $this->isCompleted = $this->courseService->areAllLessonsCompleted($this->currentLesson->course);
    }

    public function nextLesson(): void
    {
        if ($this->currentLesson->type === 'assessment') {
            $assessment = $this->currentLesson->assessment;

            $hasPassed = $assessment && AssessmentAttempt::where('user_id', auth()->id())
                    ->where('assessment_id', $assessment->id)
                    ->where('is_passed', true)
                    ->exists();

            if (!$hasPassed) {
                $this->swalWarning('Please complete the assessment before proceeding to the next lesson.');
                return;
            }
        }

        $this->courseService->markLessonComplete($this->currentLesson->id);

        if ($this->nextRoute) {
            $this->redirect($this->nextRoute, navigate: true);
        }
    }

    public function prevLesson(): void
    {
        $this->redirect($this->prevRoute, navigate: true);
    }

    public function render(): Factory|Application|View
    {
        return view('livewire.client.lesson.components.lesson-navigator');
    }
}
