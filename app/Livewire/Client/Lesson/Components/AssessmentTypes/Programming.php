<?php

namespace App\Livewire\Client\Lesson\Components\AssessmentTypes;

use App\Models\AssessmentAttempt;
use App\Services\CourseLearn\CodeRunnerService;
use App\Services\CourseLearn\CourseService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Support\Collection;
use JsonException;
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

    /**
     * @throws JsonException
     */
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

    public function submitCode(CodeRunnerService $codeRunnerService, CourseService $courseService): void
    {
        $this->reset('executionErrors');
        if ($this->userCode !== $this->template && $this->userCode) {
            $result = $codeRunnerService->run(
                $this->languageSelected,
                $this->userCode,
                $this->problem->problemDetails
            );
            $courseService->saveProgrammingAttempt(
                total_score: $result['isPassed'] ? 10 : 0,
                assessment: $this->problem,
                is_passed: $result['isPassed'],
                user_code: $this->userCode,
                language: $this->languageSelected
            );

            if ($result['isPassed']) {
                $course = $this->problem->lesson->module->course;
                $courseService->markLessonComplete($this->problem->lesson_id);
                $this->redirect(route('course.learn.lesson', [
                    'course' => $course->slug,
                    'id' => $courseService->getAdjacentLessonId($course, $this->problem->lesson_id)
                ]));

                $this->swal('Success', 'Your code passed the test cases.');
            } else {
                $this->executionErrors = $result['errors'];
            }
        } else {
            $this->swalError('Error', 'You cannot submit the template code or an empty code.');
        }
    }

    public function render(): View|Application|Factory
    {
        return view('livewire.client.lesson.components.assessment-types.programming');
    }
}
