<?php

namespace App\Validator;

use App\Models\Lesson;

class ModulesBuilderValidator {
    public static array $MESSAGES = [
        'modules.required' => 'At least one module must be created for this course.',
        'modules.*.title.required' => 'Module title is required to identify each learning section.',
        'modules.*.title.distinct' => 'Each module title must be unique within the course.',
        'modules.*.title.min' => 'Module title must be at least :min characters for clarity.',
        'modules.*.title.max' => 'Module title cannot exceed :max characters to ensure proper display.',
        'modules.*.lessons.required' => 'Each module must contain at least one lesson.',
        'modules.*.lessons.*.title.required' => 'Lesson title is required for each learning unit.',
        'modules.*.lessons.*.title.min' => 'Lesson title must be at least :min characters for clarity.',
        'modules.*.lessons.*.title.max' => 'Lesson title cannot exceed :max characters to ensure proper display.',
        'modules.*.lessons.*.type.required' => 'Lesson type must be selected to define the content format.',
        'modules.*.lessons.*.type.in' => 'Please select a valid lesson type from the available options.',
    ];

    public static function rules(): array
    {
        $lessonType = implode(',', array_keys(Lesson::$TYPES));

        return [
            'modules' => 'required|array|min:1',
            'modules.*.title' => ['required', 'min:3', 'max:255', 'distinct'],
            'modules.*.lessons' => 'required|array|min:1',
            'modules.*.lessons.*.title' => 'required|min:3|max:255',
            'modules.*.lessons.*.type' => 'required|in:' . $lessonType,
        ];
    }
}
