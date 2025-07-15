<?php

namespace App\Livewire\Client\Lesson\Components;

use App\Models\AssessmentAttempt;
use App\Models\AssessmentQuestion;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Livewire\Component;

class Assessment extends Component {
    public \App\Models\Assessment $assessment;
    public array $correctAnswers = [];
    public $answers = [];
    public $results = [];

    public function mount(): void
    {
        $this->correctAnswers = $this->assessment->questions->mapWithKeys(function ($question) {
            $correctOptionIds = $question->options
                ->where('is_correct', true)->pluck('id')->mapWithKeys(fn($id) => [$id => true])->toArray();

            return [$question->id => $correctOptionIds];
        })->toArray();
    }

    public function addAnswers($questionId, $answerID): void
    {
        if (!AssessmentQuestion::find($questionId)->isMultipleAnswers()) {
            $this->answers[$questionId] = $answerID;
        } else {
            if (!isset($this->answers[$questionId])) {
                $this->answers[$questionId] = [];
            }
            if (in_array($answerID, $this->answers[$questionId])) {
                unset($this->answers[$questionId][array_search($answerID, $this->answers[$questionId])]);
            } else {
                $this->answers[$questionId][] = $answerID;
            }
        }

    }

    public function quizSubmit()
    {
        $correctAnswers = $this->checkAnswers();
        $total = count($this->correctAnswers);

        $score = $total > 0 ? round(($correctAnswers / $total) * 10, 2) : 0;

        //        AssessmentAttempt::create([
        //            'assessment_id' => $this->assessment->id,
        //            'user_id' => auth()->id(),
        //            'total_score' => $score,
        //            'is_passed' => $score >= 5,
        //        ])->attemptAnswers()
        //            ->createMany(
        //                collect($this->answers)->map(function ($answer, $questionId) {
        //                    return [
        //                        'assessment_question_id' => $questionId,
        //                        'answer' => is_array($answer) ? json_encode($answer) : $answer,
        //                    ];
        //                })->toArray()
        //            );

        $this->results = ['correctAnswers' => $correctAnswers, 'score' => $score, 'result' => $score >= 5 ? 'pass' : 'fail',];
    }

    private function checkAnswers(): int
    {
        $score = 0;
        foreach ($this->correctAnswers as $questionId => $correctOptions) {
            $userAnswer = $this->answers[$questionId] ?? null;
            if (count($correctOptions) > 1) {
                if (!is_array($userAnswer)) {
                    continue;
                }

                $userOptionMap = collect($userAnswer)->mapWithKeys(fn($id) => [$id => true])->toArray();

                if ($userOptionMap === $correctOptions) {
                    $score++;
                }
            } else {
                $correctOptionId = array_key_first($correctOptions);
                if ($userAnswer === $correctOptionId) {
                    $score++;
                }
            }
        }
        return $score;
    }


    public function render(): View|Application|Factory
    {
        return view('livewire.client.lesson.components.assessment');
    }
}
