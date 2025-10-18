<?php

namespace App\Services\Instructor\Catalog;

use App\Models\OrderItem;
use App\Models\User;
use App\Services\Course\CourseService;
use App\Traits\HasNumberFormat;
use Illuminate\Support\Collection;

class CatalogService
{
    use HasNumberFormat;

    public function getInstructorDetails(User $instructor): User
    {
        $profile = $instructor->instructorProfile;

        $this->prepareInstructorBasicDetails($instructor);
        $instructor->courses = app(CourseService::class)->getCoursesByAuthor($instructor);
        $instructor->reviews = $instructor->reviews->sortByDesc('created_at');
        $instructor->bio = $profile->bio;
        $instructor->aboutMe = $profile->about_me;
        $instructor->socialLinks = $profile->social_links;
        $instructor->currentJob = $profile->current_job;
        $instructor->reviewCountText = $this->formatCount($profile->review_count, 'review');
        $instructor->studentCountText = $this->formatCount($profile->student_count, 'student');
        $instructor->courseCountText = $this->formatCount($profile->course_count, 'course');
        $instructor->rating = number_format($profile->rating, 1);
        return $instructor;
    }

    public function prepareInstructorBasicDetails(User $instructor): User
    {
        $instructor->avatar = $instructor->getAvatarPath();
        $instructor->profileUrl = route('instructor.details', $instructor->slug);
        return $instructor;
    }

    public function getOverviewData(User $instructor): array
    {
        $publishedCourses = app(\App\Services\Course\Catalog\CatalogService::class)->getCoursesByAuthor($instructor);
        $totalEarnings = $this->calculateTotalEarnings($publishedCourses);
        $studentsEnrolled = $instructor->instructorProfile->student_count;
        $rating = $instructor->instructorProfile->rating;
        return [
            'publishedCourses' => $publishedCourses->count(),
            'totalEarnings' => $totalEarnings,
            'studentsEnrolled' => $studentsEnrolled,
            'rating' => number_format($rating, 1),
            'reviewCount' => $instructor->instructorProfile->review_count
        ];
    }

    private function calculateTotalEarnings(Collection $publishedCourses): string
    {
        $courseIds = $publishedCourses->pluck('id');

        if ($courseIds->isEmpty()) {
            return '0';
        }

        $totalEarnings = OrderItem::whereIn('course_id', $courseIds)->sum('current_price');

        return number_format($totalEarnings);
    }
}
