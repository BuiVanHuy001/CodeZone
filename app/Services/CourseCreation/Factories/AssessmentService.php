<?php

namespace App\Services\CourseCreation\Factories;

use App\Models\Assessment;
use App\Models\QuizQuestion;
use App\Models\ProgrammingProblems;

class AssessmentService
{
    public function create(array $data, int|string $lessonId): void
    {
        $questionsCount = $data['type'] === 'quiz'
            ? count($data['assessments_questions'])
            : 1;

        $assessment = Assessment::create([
            'title' => $data['title'],
            'description' => $data['description'],
            'type' => $data['type'],
            'lesson_id' => $lessonId,
            'questions_count' => $questionsCount,
        ]);

        match ($assessment->type) {
            'quiz' => $this->storeQuizQuestions($data['assessments_questions'], $assessment->id),
            'programming' => $this->storeProgrammingAssignment($data, $assessment->id),
            default => null,
        };
    }

    private function storeProgrammingAssignment(array $data, int|string $assessmentId): void
    {
        $details = $data['problem_details'];

        ProgrammingProblems::create([
            'assessment_id' => $assessmentId,
            'function_name' => $details['function_name'],
            'code_templates' => $details['code_templates'],
            'test_cases' => $details['test_cases'],
        ]);
    }

    private function storeQuizQuestions(array $questions, int|string $assessmentId): void
    {
        foreach ($questions as $questionIndex => $questionData) {
            QuizQuestion::create([
                'content' => $questionData['content'] ?? '',
                'type' => $questionData['type'],
                'position' => $questionIndex + 1,
                'assessment_id' => $assessmentId,
                'options' => json_encode($questionData['question_options'], JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE)
            ]);
        }
    }

}
