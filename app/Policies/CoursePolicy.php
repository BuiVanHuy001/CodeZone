<?php

namespace App\Policies;

use App\Models\Course;
use App\Models\User;

class CoursePolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function access(User $user, Course $course): bool
    {
        if ($user->role === 'instructor') {
            return $course->user_id === $user->id;
        }

        if ($user->role === 'student') {
            return $course->enrollments()->where('user_id', $user->id)->exists();
        }

        return false;
    }
}
