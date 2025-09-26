<?php

namespace App\Livewire\Client\Lesson\Components\AssessmentTypes;

use App\Models\AssessmentAttempt;
use App\Models\QuizQuestion;
use App\Models\QuizAttempt;
use Carbon\Carbon;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use JsonException;
use Livewire\Component;

class Quiz extends Component
{
    public $quiz;
    public bool $isShowPreviousAttempts = true;
    public array $results = [];
    public array $userAnswers = [];
    public array $correctAnswersMap = [];
    public $selectedAttempt;

    public function mount(): void
    {
        $this->correctAnswersMap = collect($this->quiz->questions)->mapWithKeys(function ($question) {
            $options = collect($question->options);

            if ($question->isMultipleAnswers()) {
                return [
                    $question->id => $options
                        ->where('is_correct', true)
                        ->pluck('id')
                        ->sort()
                        ->values()
                        ->all()
                ];
            }

            return [
                $question->id => $options
                    ->where('is_correct', true)
                    ->pluck('id')
                    ->first()
            ];
        })->all();
    }

    /**
     * @throws JsonException
     */
    public function showAttemptDetail($attemptId): void
    {
        $this->selectedAttempt = QuizAttempt::where('assessment_attempt_id', $attemptId)->first();
        if (!$this->selectedAttempt) {
            return;
        }

        $rawAnswers = json_decode($this->selectedAttempt->user_answers, true, 512, JSON_THROW_ON_ERROR);
        $evaluatedAnswers = [];

        foreach ($rawAnswers as $questionId => $answer) {
            $correct = (array)($this->correctAnswersMap[$questionId] ?? []);
            $given = (array)$answer;
            $question = QuizQuestion::with('options')->find($questionId);
            $options = collect($question->options);

            $answerDetails = [];
            foreach ($given as $ans) {
                $option = $options->firstWhere('id', $ans);
                if ($option) {
                    $answerDetails[] = [
                        'value' => $ans,
                        'question' => $question->content,
                        'content' => $option['content'] ?? null,
                        'explanation' => $option['explanation'] ?? '',
                        'is_correct' => in_array($ans, $correct, true),
                    ];
                }
            }

            sort($correct);
            sort($given);

            $evaluatedAnswers[$questionId] = [
                'user_answers' => $answerDetails,
                'is_correct' => ($given === $correct),
            ];
        }
        $this->selectedAttempt['answers'] = $evaluatedAnswers;
        $this->dispatch('open-attempt-modal');
    }

    public function addAnswers(int $questionId, int $answerId): void
    {
        $question = collect($this->quiz->questions)->firstWhere('id', $questionId);

        if (!$question) {
            return;
        }

        if (!$question->isMultipleAnswers()) {
            $this->userAnswers[$questionId] = $answerId;
        } else {
            if (!isset($this->userAnswers[$questionId])) {
                $this->userAnswers[$questionId] = [];
            }

            $currentAnswers = &$this->userAnswers[$questionId];

            if (in_array($answerId, $currentAnswers, true)) {
                $currentAnswers = array_diff($currentAnswers, [$answerId]);
            } else {
                $currentAnswers[] = $answerId;
            }
            sort($currentAnswers);
        }
    }

    /**
     * @throws JsonException
     */
    public function quizSubmit(): void
    {
        $correctAnswers = $this->countCorrectAnswers();
        $totalQuestions = count($this->quiz->questions);
        $score = $totalQuestions > 0 ? round(($correctAnswers / $totalQuestions) * 10, 2) : 0;

        $assessmentAttempt = AssessmentAttempt::create([
            'assessment_id' => $this->quiz->id,
            'user_id' => auth()->id(),
            'total_score' => $score,
            'is_passed' => $score >= 5,
        ]);

        $quizAttempt = $assessmentAttempt->attemptQuiz()->create([
            'correct_answers_count' => $correctAnswers,
            'total_questions_count' => $totalQuestions,
            'user_answers' => json_encode($this->userAnswers, JSON_THROW_ON_ERROR),
        ]);

        $this->results = [
            'id' => $quizAttempt->assessment_attempt_id,
            'correctAnswersCount' => $correctAnswers,
            'score' => $score,
            'result' => $score >= 5 ? 'pass' : 'fail',
            'testTime' => Carbon::now(),
        ];
    }

    private function countCorrectAnswers(): int
    {
        $correctAnswerCount = 0;
        foreach ($this->userAnswers as $questionId => $answer) {
            $correctAnswer = $this->correctAnswersMap[$questionId] ?? null;
            if (is_array($answer)) {
                sort($answer);
            }
            if ($answer === $correctAnswer) {
                $correctAnswerCount++;
            }
        }
        return $correctAnswerCount;
    }

    public function hidePreviousAttemptsTable(): void
    {
        $this->isShowPreviousAttempts = false;
    }

    public function showPreviousAttemptsTable(): void
    {
        $this->isShowPreviousAttempts = true;
    }

    public function render(): View|Application|Factory
    {
        return view('livewire.client.lesson.components.assessment-types.quiz');
    }
}
