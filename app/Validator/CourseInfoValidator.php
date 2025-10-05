<?php

namespace App\Validator;

use App\Models\Course;
use App\Models\Lesson;

class CourseInfoValidator {
    public static array $MESSAGES = [
        'title.required' => 'Course title is required to identify this course.',
        'title.min' => 'Course title must be at least :min characters for clarity.',
        'title.max' => 'Course title cannot exceed :max characters to ensure proper display.',

        'slug.required' => 'Course URL slug is required for web accessibility.',
        'slug.min' => 'Course slug must be at least :min characters.',
        'slug.max' => 'Course slug cannot exceed :max characters.',
        'slug.unique' => 'This course URL already exists. Please choose a different slug.',

        'heading.required' => 'Course heading is required for course presentation.',
        'heading.min' => 'Course heading must be at least :min characters for clarity.',
        'heading.max' => 'Course heading cannot exceed :max characters to ensure proper display.',

        'description.max' => 'Course description cannot exceed :max characters.',

        'price.required' => 'Course price must be specified.',
        'price.numeric' => 'Course price must be a valid number.',
        'price.min' => 'Course price cannot be negative.',

        'category.required' => 'Course category must be selected.',
        'category.exists' => 'Selected category does not exist. Please choose a valid category.',

        'level.required' => 'Course difficulty level must be specified.',
        'level.in' => 'Please select a valid course level from the available options.',

        'startDate.required' => 'Course start date is required.',
        'startDate.date' => 'Please enter a valid start date.',
        'startDate.after_or_equal' => 'Course start date cannot be in the past.',

        'endDate.required' => 'Course end date is required.',
        'endDate.date' => 'Please enter a valid end date.',
        'endDate.after_or_equal' => 'Course end date must be after or equal to the start date.',

        'thumbnail.string' => 'Please enter a valid image URL.',

        'modules.required' => 'At least one module must be created for this course.',
        'modules.min' => 'Course must contain at least :min module.',
        'modules.*.title.required' => 'Module title is required for each learning section.',
        'modules.*.title.min' => 'Module title must be at least :min characters for clarity.',
        'modules.*.title.max' => 'Module title cannot exceed :max characters to ensure proper display.',

        'modules.*.lessons.required' => 'Each module must contain at least one lesson.',
        'modules.*.lessons.min' => 'Each module must have at least :min lesson.',
        'modules.*.lessons.*.title.required' => 'Lesson title is required for each learning unit.',
        'modules.*.lessons.*.title.min' => 'Lesson title must be at least :min characters for clarity.',
        'modules.*.lessons.*.title.max' => 'Lesson title cannot exceed :max characters to ensure proper display.',
        'modules.*.lessons.*.type.required' => 'Lesson type must be selected to define the content format.',
        'modules.*.lessons.*.type.in' => 'Please select a valid lesson type from the available options.',
    ];

    public static function rules(): array
    {
        $rules = [
            'title' => 'required|min:3|max:255',
            'slug' => 'required|min:3|max:255|unique:courses,slug',
            'heading' => 'required|min:3|max:255',
            'price' => 'required|numeric|min:0',
            'category' => 'required|exists:categories,id',
            'level' => 'required|in:' . implode(',', array_keys(Course::$LEVELS)),
            'thumbnail' => 'nullable|string',
            'modules' => 'required|array|min:1',
            'modules.*.title' => 'required|min:3|max:255',
            'modules.*.lessons' => 'required|array|min:1',
            'modules.*.lessons.*.title' => 'required|min:3|max:255',
            'modules.*.lessons.*.type' => 'required|in:' . implode(',', array_keys(Lesson::$TYPES)),
        ];
        if (auth()->user()->isOrganization()) {
            $rules['startDate'] = 'required|date|after_or_equal:today';
            $rules['endDate'] = 'required|date|after_or_equal:startDate';
        }
        return $rules;
    }
}
