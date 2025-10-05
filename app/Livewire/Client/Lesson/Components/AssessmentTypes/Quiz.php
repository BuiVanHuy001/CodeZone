<?php

namespace App\Livewire\Client\Lesson\Components\AssessmentTypes;

use App\Models\AssessmentAttempt;
use App\Services\Assessment\QuizService;
use App\Services\Course\LearningService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Support\Collection;
use Livewire\Component;

class Quiz extends Component
{
    public $quiz;
    private QuizService $quizService;
    private LearningService $learningService;
    public Collection $questions;
    public array $results = [];
    public array $resultDetails = [];
    public array $userAnswers = [];
    public $currentQuestion;
    public int $currentIndexQuestion = 0;
    public int $totalQuestions;
    public array $correctAnswersMap = [];
    public bool $isShowPreviousAttempts = true;
    public bool $isShowQuestionNavigator = false;

    public bool $canSubmit = false;
    public bool $canNext = true;
    public bool $canBack = false;
    public bool $canNextLesson = false;
    public bool $isCompleted = false;

    public string $nextLessonRoute = '';

    public function boot(): void
    {
        $this->quizService = app(
            abstract: QuizService::class,
            parameters: ['quiz' => $this->quiz]
        );
        $this->learningService = app(LearningService::class);
    }

    public function mount(): void
    {
        $this->correctAnswersMap = $this->quizService->getCorrectAnswersMap();
        $this->questions = $this->quizService->getQuestions();
        $this->currentQuestion = $this->questions[$this->currentIndexQuestion];
        $this->totalQuestions = $this->quiz->question_count;
        $this->isCompleted = AssessmentAttempt::where('assessment_id', $this->quiz->id)
            ->where('user_id', auth()->id())
            ->where('is_passed', true)
            ->exists();
    }

    public function addAnswers(int $questionId, int $answerId): void
    {
        $question = $this->questions->firstWhere('id', $questionId);
        if (!$question) return;

        $answerContent = $question['options'][$answerId]['content'] ?? null;
        if (!$answerContent) return;

        if ($question['is_multiple_answers']) {
            $this->userAnswers[$questionId] ??= [];
            if (in_array($answerContent, $this->userAnswers[$questionId], true)) {
                $this->userAnswers[$questionId] = array_values(array_diff($this->userAnswers[$questionId], [$answerContent]));
            } else {
                $this->userAnswers[$questionId][] = $answerContent;
            }

            if (empty($this->userAnswers[$questionId])) {
                unset($this->userAnswers[$questionId]);
            }
        } else {
            $this->userAnswers[$questionId] = [$answerContent];
        }

        $this->canSubmit = count($this->userAnswers) === $this->questions->count() && !$this->canNext;
    }

    public function quizSubmit(): void
    {
        $correctAnswersMap = $this->quizService->getCorrectAnswersMap();
        $this->results = $this->quizService->calculateResult($this->userAnswers, $correctAnswersMap);

        if ($this->results['is_passed']) {
            $course = $this->quiz->lesson->course;
            $this->learningService->markLessonComplete($this->quiz->lesson_id);
            if ($this->results['correct_answers_count'] === $this->totalQuestions) {
                session()->flash('swal', [
                    'icon' => 'success',
                    'title' => 'Perfect! You answered all questions correctly.',
                    'timer' => 3000,
                ]);

                $this->redirectRoute('course.learn.lesson', [
                    'slug' => $course->slug,
                    'id' => $this->learningService->getAdjacentLessonId($course, $this->quiz->lesson_id)
                ]);
            } else {
                $this->canNextLesson = true;
                $this->swal('Congratulations! You have passed the quiz.');

                $this->nextLessonRoute = route('course.learn.lesson', [
                    'slug' => $course->slug,
                    'id' => $this->learningService->getAdjacentLessonId($course, $this->quiz->lesson_id)
                ]);
            }
        } else {
            $this->swalError('You did not pass the quiz. Please try again.');
        }

        $this->resultDetails = $this->quizService->generateQuizResult($this->userAnswers);
        $this->quizService->saveAttempt($this->results);
    }

    public function nextQuestion(): void
    {
        if ($this->currentIndexQuestion < $this->totalQuestions - 1) {
            $questionId = $this->currentQuestion['id'];
            $hasValidAnswer = false;

            if (array_key_exists($questionId, $this->userAnswers)) {
                $answer = $this->userAnswers[$questionId];

                if (is_array($answer)) {
                    $hasValidAnswer = count($answer) > 0;
                } else {
                    $hasValidAnswer = $answer !== null;
                }
            }

            if ($hasValidAnswer) {
                $this->currentIndexQuestion++;
                $this->currentQuestion = $this->questions[$this->currentIndexQuestion];
                $this->canBack = $this->currentIndexQuestion > 0;
                $this->canNext = $this->currentIndexQuestion < $this->totalQuestions - 1;
                $this->canSubmit = count($this->userAnswers) === $this->questions->count() && !$this->canNext;
            } else {
                $this->swalError('Please select an answer before proceeding to the next question.');
            }
        }
    }

    public function prevQuestion(): void
    {
        if ($this->currentIndexQuestion > 0) {
            $this->currentIndexQuestion--;
            $this->currentQuestion = $this->questions[$this->currentIndexQuestion];
            $this->canBack = $this->currentIndexQuestion > 0;
            $this->canNext = true;
            $this->canSubmit = count($this->userAnswers) === $this->questions->count() && !$this->canNext;
        }
    }

    public function startQuiz(): void
    {
        $this->isShowPreviousAttempts = false;
        $this->isShowQuestionNavigator = true;
        $this->canBack = false;
        $this->canNext = $this->totalQuestions > 1;
        $this->canSubmit = false;
    }

    public function redirectToNextLesson(): void
    {
        if ($this->nextLessonRoute) {
            $this->redirect($this->nextLessonRoute);
        }
    }

    public function render(): View|Application|Factory
    {
        return view('livewire.client.lesson.components.assessment-types.quiz');
    }
}
