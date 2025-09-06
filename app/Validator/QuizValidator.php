<?php

namespace App\Validator;

use App\Models\AssessmentQuestion;
use Illuminate\Validation\Rule;

class QuizValidator {
    public static array $MESSAGES = [
        'quiz.title.required' => 'Quiz title is required to identify this assessment.',
        'quiz.title.min' => 'Quiz title must be at least :min characters for clarity.',
        'quiz.title.max' => 'Quiz title cannot exceed :max characters to ensure proper display.',
        'quiz.assessments_questions.required' => 'At least one question must be added to create a valid quiz.',
        'quiz.assessments_questions.*.content.required' => 'Question content is required for each quiz question.',
        'quiz.assessments_questions.*.type.required' => 'Question type must be selected for each question.',
        'quiz.assessments_questions.*.question_options.required' => 'At least two answer options are required for each question.',
        'quiz.assessments_questions.*.question_options.*.content.required' => 'Answer option content cannot be empty.',
        'quiz.assessments_questions.*.question_options.*.is_correct.required' => 'Each answer option must be marked as correct or incorrect.',
    ];

    public static function rules(): array
    {
        return [
            'quiz.title' => 'required|string|min:3|max:255',
            'quiz.type' => 'required|in:quiz',
            'quiz.assessments_questions' => 'required|array|min:1',
            'quiz.assessments_questions.*.content' => 'required|string',
            'quiz.assessments_questions.*.type' => [
                'required',
                Rule::in(array_keys(AssessmentQuestion::$TYPES)),
            ],
            'quiz.assessments_questions.*.question_options' => [
                'required',
                'array',
                'min:2',
                function ($attribute, $options, $fail) {
                    if (!collect($options)->contains('is_correct', true)) {
                        $fail('Each question must have at least one correct answer.');
                    }
                },
            ],
            'quiz.assessments_questions.*.question_options.*.content' => 'required|string',
            'quiz.assessments_questions.*.question_options.*.is_correct' => 'required|boolean',
        ];
    }
}
