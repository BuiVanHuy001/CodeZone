<?php

namespace App\Validator;

use App\Models\Assessment;
use App\Models\Lesson;

class NewLessonValidator {
    public static array $MESSAGES = [
        // ---- Title ----
        'lesson.title.required' => 'Please enter a lesson title.',
        'lesson.title.min' => 'The lesson title must be at least :min characters.',
        'lesson.title.max' => 'The lesson title may not exceed :max characters.',

        // ---- Type ----
        'lesson.type.required' => 'Please select a lesson type.',
        'lesson.type.in' => 'Invalid lesson type selected. Please choose a valid option.',

        // ---- Document ----
        'lesson.document.required_if' => 'A document is required when the lesson type is set to Document.',
        'lesson.document.min' => 'The document content must be at least :min characters long.',

        // ---- Assessment (container) ----
        'lesson.assessment.required_if' => 'Assessment data is required when the lesson type is set to Assessment.',

        // ---- Assessment Title ----
        'lesson.assessment.title.required_if' => 'Please enter a title for the assessment.',
        'lesson.assessment.title.min' => 'The assessment title must be at least :min characters.',
        'lesson.assessment.title.max' => 'The assessment title may not exceed :max characters.',

        // ---- Assessment Description ----
        'lesson.assessment.description.required_if' => 'An assessment description is required when the lesson type is Assessment.',
        'lesson.assessment.description.min' => 'The assessment description must be at least :min characters.',
        'lesson.assessment.description.in' => 'The assessment description must be one of the allowed types: assignment or programming.',

        // ---- Assessment Type ----
        'lesson.assessment.type.required_if' => 'Please select an assessment type when the lesson type is Assessment.',
        'lesson.assessment.type.in' => 'Invalid assessment type selected. Please choose a valid option.',

        // ---- Quiz Questions ----
        'lesson.assessment.assessments_questions.required_if' => 'At least one question is required when the assessment type is Quiz.',
        'lesson.assessment.assessments_questions.array' => 'The questions must be provided as a valid list.',
        'lesson.assessment.assessments_questions.min' => 'The quiz must contain at least :min question.',
        // ---- Video File ----
        'lesson.video_file_name.required_if' => 'A video file is required when the lesson type is set to Video.',
        'lesson.video_file_name.max' => 'The video file size must not exceed 250 MB.',
        'lesson.video_file_name.mimes' => 'The video file must be in one of the following formats: MP4, MOV, or WEBM.',

        'lesson.duration.required_if' => 'A video duration is required when the lesson type is set to Video.',
        'lesson.duration.numeric' => 'The video duration must be a valid number (in seconds).',
        'lesson.duration.min' => 'The video duration must be at least :min seconds.',

        'lesson.preview.required' => 'Please specify whether this lesson should be available as a preview.',
        'lesson.preview.boolean' => 'The preview value must be true or false.',
    ];

    public static function rules(array $existingLessonTitles = []): array
    {
        $lessonType = implode(',', array_keys(Lesson::$TYPES));
        $assessmentType = implode(',', array_keys(Assessment::$ASSESSMENT_PRACTICE_TYPES));

        $rules = [
            'lesson.title' => 'required|min:3|max:255',
            'lesson.type' => 'required|in:' . $lessonType,

            'lesson.document' => 'required_if:lesson.type,document|min:3',

            'lesson.assessment' => 'required_if:lesson.type,assessment',
            'lesson.assessment.title' => 'required_if:lesson.type,assessment|min:3|max:255',
            'lesson.assessment.description' => 'required_if:lesson.assessment.type,assignment,programming|min:3',
            'lesson.assessment.type' => 'required_if:lesson.type,assessment|in:' . $assessmentType,

            'lesson.assessment.programming' => 'nullable|array',

            'lesson.video_file_name' => 'required_if:lesson.type,video|max:250000',
            'lesson.duration' => 'required_if:lesson.type,video|numeric|min:0',

            'lesson.preview' => 'required|boolean',
        ];

        if (is_string($rules['lesson.title'])) {
            $rules['lesson.title'] = explode('|', $rules['lesson.title']);
        }

        $rules['lesson.title'][] = function ($attribute, $value, $fail) use ($existingLessonTitles) {
            $incomingTitle = mb_strtolower(trim((string)$value));

            if ($incomingTitle !== '') {
                $normalizedExisting = array_map(
                    fn($t) => mb_strtolower(trim((string)$t)),
                    $existingLessonTitles ?? []
                );

                if (in_array($incomingTitle, $normalizedExisting, true)) {
                    $fail('Lesson title must be unique within the module.');
                }
            }
        };

        return $rules;
    }

    public static function rulesFor(string $field): array
    {
        $rules = [];

        foreach (self::rules([]) as $key => $rule) {
            if ($key === "lesson.$field" || str_starts_with($key, "lesson.$field.")) {
                $shortKey = str_starts_with($key, 'lesson.')
                    ? substr($key, strlen('lesson.'))
                    : $key;

                $ruleParts = is_string($rule) ? explode('|', $rule) : (array)$rule;

                $cleaned = array_map(function ($r) {
                    if (str_starts_with($r, 'required_if')) {
                        return 'required';
                    }
                    return $r;
                }, $ruleParts);

                $rules[$shortKey] = implode('|', $cleaned);
            }
        }

        return $rules;
    }

    public static function messagesFor(string $field): array
    {
        $messages = [];

        foreach (self::$MESSAGES as $key => $message) {
            if ($key === "lesson.$field" || str_starts_with($key, "lesson.$field.")) {
                $shortKey = str_starts_with($key, 'lesson.')
                    ? substr($key, strlen('lesson.'))
                    : $key;

                if (str_ends_with($shortKey, '.required_if')) {
                    $shortKey = str_replace('.required_if', '.required', $shortKey);
                }

                $messages[$shortKey] = $message;
            }
        }

        return $messages;
    }

    public static function rulesForAs(string $fromField, string $toField): array
    {
        $original = self::rulesFor($fromField);
        $remapped = [];

        foreach ($original as $key => $rule) {
            if ($key === $fromField) {
                $newKey = $toField;
            } elseif (str_starts_with($key, $fromField . '.')) {
                $newKey = $toField . substr($key, strlen($fromField));
            } else {
                $newKey = $key;
            }
            $remapped[$newKey] = $rule;
        }

        return $remapped;
    }

    public static function messagesForAs(string $fromField, string $toField): array
    {
        $messages = [];

        foreach (self::$MESSAGES as $key => $message) {
            if ($key === "lesson.$fromField" || str_starts_with($key, "lesson.$fromField.")) {
                $shortKey = str_starts_with($key, 'lesson.')
                    ? substr($key, strlen('lesson.'))
                    : $key;

                if (str_ends_with($shortKey, '.required_if')) {
                    $shortKey = str_replace('.required_if', '.required', $shortKey);
                }
                if ($shortKey === $fromField || str_starts_with($shortKey, $fromField . '.')) {
                    $newKey = $toField . substr($shortKey, strlen($fromField));
                } else {
                    $newKey = $shortKey;
                }

                $messages[$newKey] = $message;
            }
        }
        return $messages;
    }

}
