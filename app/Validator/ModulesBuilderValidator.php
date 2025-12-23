<?php

namespace App\Validator;

class ModulesBuilderValidator {
    public static array $MESSAGES = [
        'moduleTitle.required' => 'Tên chương học không được để trống.',
        'moduleTitle.min' => 'Tên chương phải có ít nhất :min ký tự.',
        'moduleTitle.max' => 'Tên chương không được vượt quá :max ký tự.',
    ];

    public static function rules(): array
    {
        return [
            'moduleTitle' => 'required|min:3|max:255',
        ];
    }
}
