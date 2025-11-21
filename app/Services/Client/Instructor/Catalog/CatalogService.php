<?php

namespace App\Services\Client\Instructor\Catalog;

use App\Models\User;
use App\Services\Client\Course\CourseService;
use App\Traits\HasNumberFormat;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Spatie\Permission\Models\Role;

class CatalogService {
    use HasNumberFormat;

    public function getDetails(User $instructor): User
    {
        $profile = $instructor->instructorProfile;

        $this->prepareBasicDetails($instructor);
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

    public function prepareDetailForCourseDetail(User $instructor): User
    {
        $profile = $instructor->instructorProfile;

        $this->prepareBasicDetails($instructor);
        $instructor->courseCountText = $this->formatCount($profile->course_count, 'course');
        $instructor->rating = number_format($profile->rating, 1);
        $instructor->reviewCountText = $this->formatCount($profile->review_count, 'review');
        $instructor->currentJob = $profile->current_job;
        $instructor->aboutMe = $profile->about_me;
        return $instructor;
    }

    public function prepareBasicDetails(User $instructor): User
    {
        $instructor->avatar = $instructor->getAvatarPath();
        $instructor->profileUrl = route('instructor.details', $instructor->slug);
        return $instructor;
    }

    public function getOverviewData(User $instructor): array
    {
        $cacheKey = 'instructor_overview_' . $instructor->id;

        return Cache::remember($cacheKey, now()->addMinutes(30), function () use ($instructor) {
            $publishedCourses = app(\App\Services\Client\Course\Catalog\CatalogService::class)->getCoursesByAuthor($instructor);
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
        });
    }

    public function getDetailsForAdminList(string $status): Collection
    {
        $instructors = Role::findByName('instructor')->users()->with([
            'instructorProfile',
            'instructorProfile.major',
            'instructorProfile.major.faculty',
            'courses',
            'courses.orderItems',
            'reviews'
        ])->where('status', $status)
            ->get();

        return $instructors->map(function (User $instructor) {
            return $this->prepareDetailsForAdminList($instructor);
        });
    }

    private function prepareDetailsForAdminList(User $instructor): User
    {
        $publishedCourses = $instructor->courses;
        $profile = $instructor->instructorProfile;
        $this->prepareBasicDetails($instructor);
        $instructor->totalEarningsText = $this->calculateTotalEarnings($publishedCourses);
        $instructor->createdAtText = $instructor->created_at->diffForHumans();
        $instructor->updatedAtText = $instructor->updated_at->diffForHumans();
        if ($profile && $profile->major) {
            $majorName = $profile->major->name ?? 'N/A';
            $facultyCode = $profile->major->faculty->code ?? ($profile->faculty->code ?? 'N/A');
            $instructor->majorText = $majorName . ' (' . $facultyCode . ')';
        } else {
            $instructor->majorText = 'N/A';
        }
        if ($profile) {
            $instructor->studentCountText = $this->formatCount($profile->student_count, 'student');
            $instructor->courseCountText = $this->formatCount($profile->course_count, 'course');
            $instructor->ratingText = number_format($profile->rating, 1) . '/5⭐' . ' (' . $this->formatCount($profile->review_count, 'review') . ')';
        }
        return $instructor;
    }

    private function calculateTotalEarnings(Collection $publishedCourses): string
    {
        $publishedCourses->load('orderItems');

        $totalEarnings = $publishedCourses
            ->flatMap(function ($course) {
                return $course->orderItems ?? collect();
            })
            ->sum('current_price');

        return $this->formatCurrency($totalEarnings);
    }
}
