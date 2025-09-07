<?php

namespace App\Validator;

class ModulesBuilderValidator {
    public static array $MESSAGES = [
        'moduleTitle.required' => 'Title is required.',
        'moduleTitle.min' => 'Title must be at least :min characters.',
        'moduleTitle.max' => 'Title cannot exceed :max characters.',
    ];

    public static function rules(): array
    {
        return [
            'moduleTitle' => 'required|min:3|max:255',
        ];
    }
}
