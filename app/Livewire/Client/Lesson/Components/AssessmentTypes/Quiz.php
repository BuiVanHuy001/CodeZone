<?php

namespace App\Livewire\Client\Lesson\Components\AssessmentTypes;

use App\Models\AssessmentAttempt;
use App\Models\AssessmentQuestion;
use App\Models\AttemptQuiz;
use Carbon\Carbon;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
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
	    $this->quiz = $this->quiz->load('questions.options');
        $this->correctAnswersMap = $this->quiz->questions->mapWithKeys(function ($question) {
	        if ($question->isMultipleAnswers()) {
		        return [
			        $question->id => $question->options
				        ->where('is_correct', true)
				        ->pluck('id')
				        ->sort()
				        ->values()
				        ->toArray()
		        ];
	        } else {
		        return [
			        $question->id => $question->options
				        ->where('is_correct', true)
				        ->pluck('id')
				        ->first()
		        ];
	        }
        })->toArray();
    }

	public function showAttemptDetail($attemptId): void
	{
		$this->selectedAttempt = AttemptQuiz::where('assessment_attempt_id', $attemptId)->first();
		$rawAnswers = json_decode($this->selectedAttempt->user_answers, true);

		$evaluatedAnswers = [];

		foreach ($rawAnswers as $questionId => $answer) {
			$correct = (array)($this->correctAnswersMap[$questionId] ?? []);
			$given = (array)$answer;
			$question = AssessmentQuestion::where('id', $questionId)->with('options')->first();

			$answerDetails = [];
			foreach ($given as $ans) {
				$answerDetails[] = [
					'value' => $ans,
					'question' => $question->content,
					'content' => $question->options->where('id', $ans)->first()->content,
					'explanation' => $question->options->where('id', $ans)->first()->explanation ?? '',
					'is_correct' => in_array($ans, $correct),
				];
			}

			// Fix: Check both values and count for multiple answers
			sort($correct);
			sort($given);
			$isCorrect = ($given === $correct);

			$evaluatedAnswers[$questionId] = [
				'user_answers' => $answerDetails,
				'is_correct' => $isCorrect,
			];
		}
		$this->selectedAttempt['answers'] = $evaluatedAnswers;
		$this->dispatch('open-attempt-modal');
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
	    $correctAnswers = $this->countCorrectAnswers();
        $totalQuestions = count($this->quiz->questions);
        $score = $totalQuestions > 0 ? round(($correctAnswers / $totalQuestions) * 10, 2) : 0;

	    $quizAttempt = AssessmentAttempt::create([
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
	        'id' => $quizAttempt->assessment_attempt_id,
            'correctAnswersCount' => $correctAnswers,
            'score' => $score,
            'result' => $score >= 5 ? 'pass' : 'fail',
            'testTime' => Carbon::now(),
        ];
    }

	private function countCorrectAnswers(): int
    {
	    $correctAnswer = 0;
	    foreach ($this->userAnswers as $questionId => $answer) {
		    if (is_array($answer)) {
			    sort($answer);
		    }
		    if ($answer === $this->correctAnswersMap[$questionId]) {
			    $correctAnswer++;
		    }
	    }
	    return $correctAnswer;
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
