<?php

namespace App\Validator;

class InstructorValidator {
    public static array $MESSAGES = [
        // Name rules
        'name.required' => 'The instructor\'s full name is required.',
        'name.string' => 'The name must be a valid text string.',
        'name.min' => 'The name must be at least :min characters long.',

        // Email rules
        'email.required' => 'An email address is required.',
        'email.email' => 'Please provide a valid email address format (e.g., user@example.com).',
        'email.unique' => 'This email address is already associated with another account.',

        // Password rules
        'password.required' => 'A password is required for the account.',
        'password.string' => 'The password must be a text string.',
        'password.min' => 'The password must be at least :min characters long for security.',

        // Avatar (file upload) rules
        'avatar.image' => 'The uploaded avatar must be a valid image file (jpeg, png, bmp, gif, or svg).',
        'avatar.max' => 'The avatar image size cannot exceed :max kilobytes (5MB).',
        'avatar.prohibits' => 'You cannot upload an avatar AND use an avatar link. Please choose one.',

        // Avatar (URL) rules
        'avatarLink.url' => 'The provided avatar link must be a valid URL.',
        'avatarLink.prohibits' => 'You cannot use an avatar link AND upload an avatar. Please choose one.',

        // Gender rules
        'gender.required' => 'Please select a gender for the instructor.',
        'gender.in' => 'The selected gender is invalid. Please choose from the provided options.',

        // Major ID rules
        'major_id.required' => 'The instructor\'s major is required.',
        'major_id.exists' => 'The selected major is invalid or does not exist in our records.',
    ];

    public static function rules(): array
    {
        return [
            'name' => 'required|string|min:3',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'avatar' => 'nullable|image|max:5120|prohibits:avatarLink',
            'avatarLink' => 'nullable|url|prohibits:avatar',
            'gender' => 'required|in:male,female,other',
            'major_id' => 'required|exists:majors,id',
        ];
    }
}
