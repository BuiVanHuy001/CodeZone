<?php

namespace App\Livewire\Client\Lesson\Components\AssessmentTypes;

use App\Models\AssessmentAttempt;
use Carbon\Carbon;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Livewire\Component;

class Quiz extends Component
{
    public $quiz;
    public array $results = [];
    public array $userAnswers = [];
    public array $correctAnswersMap = [];

    public function mount(): void
    {
        $this->correctAnswersMap = $this->quiz->questions->mapWithKeys(function ($question) {
            return [
                $question->id => $question->options
                    ->where('is_correct', true)
                    ->pluck('id')
                    ->sort()
                    ->values()
                    ->toArray()
            ];
        })->toArray();
    }

    public function addAnswers(int $questionId, int $answerId): void
    {
        $question = $this->quiz->questions->firstWhere('id', $questionId);

        if (!$question) {
            return;
        }

        if (!$question->isMultipleAnswers()) {
            $this->userAnswers[$questionId] = $answerId;
        } else {
            if (!isset($this->userAnswers[$questionId])) {
                $this->userAnswers[$questionId] = [];
            }

            $currentAnswers = $this->userAnswers[$questionId];

            if (in_array($answerId, $currentAnswers)) {
                $this->userAnswers[$questionId] = array_diff($currentAnswers, [$answerId]);
            } else {
                $this->userAnswers[$questionId][] = $answerId;
            }
            sort($this->userAnswers[$questionId]);
        }
    }

    public function quizSubmit(): void
    {
        $correctAnswers = $this->checkAnswers();
        $totalQuestions = count($this->quiz->questions);
        $score = $totalQuestions > 0 ? round(($correctAnswers / $totalQuestions) * 10, 2) : 0;

        AssessmentAttempt::create([
            'assessment_id' => $this->quiz->id,
            'user_id' => auth()->id(),
            'total_score' => $score,
            'is_passed' => $score >= 5,
        ])->attemptQuiz()->create([
            'correct_answers_count' => $correctAnswers,
            'total_questions_count' => $totalQuestions,
            'user_answers' => json_encode($this->userAnswers),
        ]);

        $this->results = [
            'correctAnswersCount' => $correctAnswers,
            'score' => $score,
            'result' => $score >= 5 ? 'pass' : 'fail',
            'testTime' => Carbon::now(),
        ];
    }


    private function checkAnswers(): int
    {
        $score = 0;

        foreach ($this->quiz->questions as $question) {
            $questionId = $question->id;
            $userAnswer = $this->userAnswers[$questionId] ?? null;
            $correctOptions = $this->correctAnswersMap[$questionId] ?? [];

            if ($question->isMultipleAnswers()) {
                if (is_array($userAnswer) && count($userAnswer) === count($correctOptions) && empty(array_diff($userAnswer, $correctOptions))) {
                    $score++;
                }
            } else {
                $correctOptionId = $correctOptions[0] ?? null;

                if ($userAnswer === $correctOptionId) {
                    $score++;
                }
            }
        }
        return $score;
    }

    public function render(): View|Application|Factory
    {
        return view('livewire.client.lesson.components.assessment-types.quiz');
    }
}
