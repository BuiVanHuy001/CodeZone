<?php

namespace App\Services\Client\Assessment;

use App\Models\Assessment;
use App\Models\AssessmentAttempt;
use Illuminate\Support\Collection;

class QuizService
{
    public array $questions = [];

    public function __construct(
        protected Assessment $quiz
    )
    {
        foreach ($this->quiz->questions as $question) {
            $this->questions[] = [
                'id' => $question->id,
                'content' => $question->content,
                'options' => json_decode($question['options'], true, 512, JSON_THROW_ON_ERROR),
                'is_multiple_answers' => $question->isMultipleAnswers(),
            ];
        }
    }

    public function getCorrectAnswersMap(): array
    {
        $map = [];
        foreach ($this->questions as $question) {
            foreach ($question['options'] as $option) {
                if ($option['is_correct']) {
                    $map[$question['id']][] = $option['content'];
                }
            }
        }
        return $map;
    }

    public function getQuestions(): Collection
    {
        return $this->quiz->questions->map(fn($q) => [
            'id' => $q->id,
            'content' => $q->content,
            'type' => $q->type,
            'options' => json_decode($q->options, true, 512, JSON_THROW_ON_ERROR),
            'is_multiple_answers' => $q->isMultipleAnswers(),
        ]);
    }

    public function checkAnswer(int $questionId, array|int $userAnswer, array $correctAnswersMap): bool
    {
        $correct = $correctAnswersMap[$questionId] ?? null;

        if (is_array($userAnswer)) {
            sort($userAnswer);
            sort($correct);
        }
        return $userAnswer === $correct;
    }

    public function calculateResult(array $userAnswers, array $correctAnswersMap): array
    {
        $correctCount = 0;
        foreach ($userAnswers as $qId => $answer) {
            if ($this->checkAnswer($qId, $answer, $correctAnswersMap)) {
                $correctCount++;
            }
        }

        $totalQuestions = count($correctAnswersMap);
        $score = $totalQuestions > 0 ? round(($correctCount / $totalQuestions) * 10, 2) : 0;

        return [
            'correct_answers_count' => $correctCount,
            'is_passed' => $score >= 5,
        ];
    }

    public function saveAttempt(array $results): void
    {
        if (auth()->user()->hasRole('student')) {
            AssessmentAttempt::create([
                'assessment_id' => $this->quiz->id,
                'user_id' => auth()->id(),
                'is_passed' => $results['is_passed'],
            ]);
        }
    }

    public function generateQuizResult(array $userAnswers): array
    {
        $detailedResults = [];

        foreach ($userAnswers as $questionId => $selectedAnswers) {
            $question = collect($this->questions)->firstWhere('id', $questionId);
            if (!$question) continue;

            $questionResult = [
                'question_content' => $question['content'],
                'is_multiple_answers' => $question['is_multiple_answers'],
                'selected_answers' => [],
                'correct_answers' => [],
            ];

            foreach ($question['options'] as $index => $option) {
                if ($option['is_correct']) {
                    $questionResult['correct_answers'][] = [
                        'index' => $index,
                        'content' => $option['content'],
                        'explanation' => $option['explanation'] ?? ''
                    ];
                }
            }

            foreach ($selectedAnswers as $selectedContent) {
                foreach ($question['options'] as $index => $option) {
                    if ($option['content'] === $selectedContent) {
                        $questionResult['selected_answers'][] = [
                            'index' => $index,
                            'content' => $option['content'],
                            'is_correct' => $option['is_correct'],
                            'explanation' => $option['explanation'] ?? ''
                        ];
                        break;
                    }
                }
            }

            $selectedCorrectContents = array_column(
                array_filter($questionResult['selected_answers'], fn($ans) => $ans['is_correct']),
                'content'
            );
            $allCorrectContents = array_column($questionResult['correct_answers'], 'content');

            sort($selectedCorrectContents);
            sort($allCorrectContents);

            $questionResult['is_question_correct'] = ($selectedCorrectContents === $allCorrectContents);

            $detailedResults[$questionId] = $questionResult;
        }

        return $detailedResults;
    }
}
