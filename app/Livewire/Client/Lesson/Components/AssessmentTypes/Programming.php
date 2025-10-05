<?php

namespace App\Livewire\Client\Lesson\Components\AssessmentTypes;

use App\Models\AssessmentAttempt;
use App\Services\Assessment\CodeRunnerService;
use App\Services\Course\LearningService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Support\Collection;
use Livewire\Attributes\On;
use Livewire\Component;

class Programming extends Component
{
    public $problem;
    public $codeTemplates = [];
    public $allowedLanguages = [];
    public string $languageSelected;
    public string $userCode = '';
    public string $template;
    public string $executionErrors = '';
    public ?Collection $attemptProgrammings;

    public function mount(): void
    {
        $decodedTemplates = json_decode($this->problem->problemDetails['code_templates'], true, 512, JSON_THROW_ON_ERROR);
        $this->codeTemplates = $decodedTemplates;
        $this->allowedLanguages = array_keys($decodedTemplates);
        $this->languageSelected = $this->allowedLanguages[0];

        $attempt = AssessmentAttempt::where('assessment_id', $this->problem->id)
            ->where('user_id', auth()->id())
            ->with('attemptProgrammings')
            ->first();

        $this->attemptProgrammings = $attempt->attemptProgrammings ?? collect();

        $existing = $this->attemptProgrammings->firstWhere('language', $this->languageSelected);
        if ($existing) {
            $this->userCode = $existing->user_code;
            $this->template = $existing->user_code;
        } else {
            $this->template = $this->codeTemplates[$this->languageSelected] ?? '';
            $this->userCode = '';
        }
        $this->dispatch('code-editor-initialize',
            editorId: 'code-editor-' . $this->problem->id,
            doc: $this->template,
            language: $this->languageSelected
        );
    }
    public function updatedLanguageSelected(): void
    {
        $existing = $this->attemptProgrammings->firstWhere('language', $this->languageSelected);
        if ($existing) {
            $this->template = $existing->user_code;
            $this->userCode = $existing->user_code;
        } else {
            $this->template = $this->codeTemplates[$this->languageSelected] ?? '';
            $this->userCode = '';
        }

        $this->dispatch('language-changed',
            editorId: 'code-editor-' . $this->problem->id,
            doc: $this->template,
            language: $this->languageSelected
        );
    }

    #[On('code-editor-blur')]
    public function updateCodeEditor(string $code): void
    {
        $this->userCode = $code;
    }

    public function submitCode(CodeRunnerService $codeRunnerService, LearningService $courseService): void
    {
        $this->reset('executionErrors');
        if ($this->userCode !== $this->template && $this->userCode) {
            $result = $codeRunnerService->run(
                $this->languageSelected,
                $this->userCode,
                $this->problem->problemDetails
            );

            if ($result['isPassed']) {
                $codeRunnerService->saveProgrammingAttempt(
                    assessment: $this->problem,
                    is_passed: $result['isPassed'],
                    user_code: $this->userCode,
                    language: $this->languageSelected
                );

                $course = $this->problem->lesson->course;
                $courseService->markLessonComplete($this->problem->lesson_id);
                $this->redirect(route('course.learn.lesson', [
                    'slug' => $course->slug,
                    'id' => $courseService->getAdjacentLessonId($course, $this->problem->lesson_id)
                ]));

                $this->swal('Success', 'Your code passed the test cases.');
            } else {
                $this->executionErrors = $result['errors'];
            }
        } elseif ($this->attemptProgrammings->firstWhere('language', $this->languageSelected)->user_code === $this->userCode) {
            $this->swal(
                title: 'You have already submitted this code.',
                icon: 'info'
            );
        } else {
            $this->swal(
                title: 'You cannot submit the template code or an empty code.',
                icon: 'warning'
            );
        }
    }

    public function render(): View|Application|Factory
    {
        return view('livewire.client.lesson.components.assessment-types.programming');
    }
}
