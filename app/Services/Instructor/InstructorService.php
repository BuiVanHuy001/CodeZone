<?php

namespace App\Services\Instructor;

use App\Models\User;
use App\Services\Course\CatalogService;

class InstructorService
{
    public function prepareDetails(User $instructor): User
    {
        $catalogService = app(CatalogService::class);
        $profile = $instructor->instructorProfile;

        $instructor->avatar = $instructor->getAvatarPath();
        $instructor->courses = $catalogService->getAllCourse($instructor);
        $instructor->reviews = $instructor->reviews->sortByDesc('created_at');
        $instructor->bio = $profile->bio;
        $instructor->aboutMe = $profile->about_me;
        $instructor->socialLinks = $profile->social_links;
        $instructor->currentJob = $profile->current_job;
        $instructor->profileUrl = route('instructor.details', $instructor->slug);
        $instructor->reviewCountText = $this->formatCount($profile->review_count, 'review');
        $instructor->studentCountText = $this->formatCount($profile->student_count, 'student');
        $instructor->courseCountText = $this->formatCount($profile->course_count, 'course');
        $instructor->rating = number_format($profile->rating, 1);
        return $instructor;
    }

    public function formatCount(int $count, string $word): string
    {
        return $count . ' ' . str($word)->plural($count);
    }
}
