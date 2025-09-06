<?php

namespace App\Validator;

use App\Models\Assessment;
use App\Models\AssessmentQuestion;
use App\Models\Lesson;

class NewLessonValidator {
    public static array $MESSAGES = [
        // ---- Title ----
        'newLesson.title.required' => 'Please enter a lesson title.',
        'newLesson.title.min' => 'The lesson title must be at least :min characters.',
        'newLesson.title.max' => 'The lesson title may not exceed :max characters.',

        // ---- Type ----
        'newLesson.type.required' => 'Please select a lesson type.',
        'newLesson.type.in' => 'Invalid lesson type selected. Please choose a valid option.',

        // ---- Document ----
        'newLesson.document.required_if' => 'A document is required when the lesson type is set to Document.',
        'newLesson.document.min' => 'The document content must be at least :min characters long.',

        // ---- Assessment (container) ----
        'newLesson.assessment.required_if' => 'Assessment data is required when the lesson type is set to Assessment.',

        // ---- Assessment Title ----
        'newLesson.assessment.title.required_if' => 'Please enter a title for the assessment.',
        'newLesson.assessment.title.min' => 'The assessment title must be at least :min characters.',
        'newLesson.assessment.title.max' => 'The assessment title may not exceed :max characters.',

        // ---- Assessment Description ----
        'newLesson.assessment.description.required_if' => 'An assessment description is required when the lesson type is Assessment.',
        'newLesson.assessment.description.min' => 'The assessment description must be at least :min characters.',
        'newLesson.assessment.description.in' => 'The assessment description must be one of the allowed types: assignment or programming.',

        // ---- Assessment Type ----
        'newLesson.assessment.type.required_if' => 'Please select an assessment type when the lesson type is Assessment.',
        'newLesson.assessment.type.in' => 'Invalid assessment type selected. Please choose a valid option.',

        // ---- Quiz Questions ----
        'newLesson.assessment.assessments_questions.required_if' => 'At least one question is required when the assessment type is Quiz.',
        'newLesson.assessment.assessments_questions.array' => 'The questions must be provided as a valid list.',
        'newLesson.assessment.assessments_questions.min' => 'The quiz must contain at least :min question.',
        // ---- Video File ----
        'newLesson.video_file_name.required_if' => 'A video file is required when the lesson type is set to Video.',
        'newLesson.video_file_name.max' => 'The video file size must not exceed 250 MB.',
        'newLesson.video_file_name.mimes' => 'The video file must be in one of the following formats: MP4, MOV, or WEBM.',

        'newLesson.duration.required_if' => 'A video duration is required when the lesson type is set to Video.',
        'newLesson.duration.numeric' => 'The video duration must be a valid number (in seconds).',
        'newLesson.duration.min' => 'The video duration must be at least :min seconds.',

        'newLesson.preview.required' => 'Please specify whether this lesson should be available as a preview.',
        'newLesson.preview.boolean' => 'The preview value must be true or false.',
    ];

    public static function rules(): array
    {
        $lessonType = implode(',', array_keys(Lesson::$TYPES));
        $assessmentType = implode(',', array_keys(Assessment::$ASSESSMENT_PRACTICE_TYPES));

        return [
            'newLesson.title' => 'required|min:3|max:255',
            'newLesson.type' => 'required|in:' . $lessonType,

            'newLesson.document' => 'required_if:newLesson.type,document|min:3',

            'newLesson.assessment' => 'required_if:newLesson.type,assessment',
            'newLesson.assessment.title' => 'required_if:newLesson.type,assessment|min:3|max:255',
            'newLesson.assessment.description' => 'required_if:newLesson.assessment.type,assignment,programming|min:3',
            'newLesson.assessment.type' => 'required_if:newLesson.type,assessment|in:' . $assessmentType,

            'newLesson.assessment.programming' => 'nullable|array',

            'newLesson.video_file_name' => 'required_if:newLesson.type,video|max:250000',
            'newLesson.duration' => 'required_if:newLesson.type,video|numeric|min:0',

            'newLesson.preview' => 'required|boolean',
        ];
    }

    public static function rulesFor(string $field): array
    {
        $rules = [];

        foreach (self::rules() as $key => $rule) {
            if ($key === "newLesson.$field" || str_starts_with($key, "newLesson.$field.")) {
                $shortKey = str_starts_with($key, 'newLesson.')
                    ? substr($key, strlen('newLesson.'))
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
            if ($key === "newLesson.$field" || str_starts_with($key, "newLesson.$field.")) {
                $shortKey = str_starts_with($key, 'newLesson.')
                    ? substr($key, strlen('newLesson.'))
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
            if ($key === "newLesson.$fromField" || str_starts_with($key, "newLesson.$fromField.")) {
                $shortKey = str_starts_with($key, 'newLesson.')
                    ? substr($key, strlen('newLesson.'))
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
