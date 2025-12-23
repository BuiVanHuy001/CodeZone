<?php

namespace App\Policies;

use App\Models\Course;
use App\Models\User;

class CoursePolicy
{
    public function access(User $user, Course $course): bool
    {
        if ($user->hasRole('instructor')) {
            return $course->user_id === $user->id;
        }

        if ($user->hasRole('student')) {
            return $course->enrollments()->where('user_id', $user->id)->exists();
        }

        if ($user->hasRole('admin')) {
            return true;
        }

        return false;
    }
}
