<?php

namespace App\Validator;

use App\Models\QuizQuestion;
use Illuminate\Validation\Rule;

class QuizValidator {
    public static array $MESSAGES = [
        'quiz.title.required' => 'Tiêu đề bài trắc nghiệm không được để trống.',
        'quiz.title.min' => 'Tiêu đề bài trắc nghiệm phải có ít nhất :min ký tự.',
        'quiz.title.max' => 'Tiêu đề bài trắc nghiệm không được vượt quá :max ký tự.',
        'quiz.assessments_questions.required' => 'Vui lòng thêm ít nhất một câu hỏi để tạo bài trắc nghiệm.',
        'quiz.assessments_questions.*.content.required' => 'Nội dung câu hỏi không được để trống.',
        'quiz.assessments_questions.*.type.required' => 'Vui lòng chọn loại câu hỏi.',
        'quiz.assessments_questions.*.question_options.required' => 'Mỗi câu hỏi phải có ít nhất hai lựa chọn trả lời.',
        'quiz.assessments_questions.*.question_options.*.content.required' => 'Nội dung lựa chọn trả lời không được để trống.',
        'quiz.assessments_questions.*.question_options.*.is_correct.required' => 'Vui lòng xác định lựa chọn này là đúng hay sai.',
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
                Rule::in(array_keys(QuizQuestion::$TYPES)),
            ],
            'quiz.assessments_questions.*.question_options' => [
                'required',
                'array',
                'min:2',
                function ($attribute, $options, $fail) {
                    if (!collect($options)->contains('is_correct', true)) {
                        $fail('Mỗi câu hỏi phải có ít nhất một đáp án đúng.');
                    }
                },
            ],
            'quiz.assessments_questions.*.question_options.*.content' => 'required|string',
            'quiz.assessments_questions.*.question_options.*.is_correct' => 'required|boolean',
        ];
    }
}
