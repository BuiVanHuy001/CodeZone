<?php

namespace App\Services\Instructor;

use App\Models\Course;
use App\Models\OrderItem;
use App\Models\User;
use App\Services\Course\Catalog\CatalogService;
use App\Traits\HasNumberFormat;
use Illuminate\Support\Collection;

readonly class InstructorService
{
    use HasNumberFormat;

    public function __construct(private CatalogService $catalogService) { }

    public function prepareDetails(User $instructor): User
    {
        $catalogService = app(CatalogService::class);
        $profile = $instructor->instructorProfile;

        $instructor->avatar = $instructor->getAvatarPath();
        $instructor->courses = $catalogService->getCoursesByAuthor($instructor);
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

    public function prepareBasicDetails(User $instructor): User
    {
        $instructor->avatar = $instructor->getAvatarPath();
        $instructor->profileUrl = route('instructor.details', $instructor->slug);
        return $instructor;
    }

    public function getTopInstructors(): Collection
    {
        $instructors = User::where('role', 'instructor')
            ->whereHas('instructorProfile', function ($query) {
                $query->where('course_count', '>', 0);
            })
            ->with('instructorProfile')
            ->get();
        return $instructors->sortByDesc(fn($instructor) => $instructor->instructorProfile->rating);
    }

    public function getInstructorOverviewData(User $instructor): array
    {
        $publishedCourses = $this->catalogService->getCoursesByAuthor($instructor);
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
        $totalEarnings = 0;
        foreach ($publishedCourses as $course) {

            $totalEarnings += OrderItem::where('course_id', $course->id)->sum('current_price');
        }
        return number_format($totalEarnings);
    }

    public function getInstructorCourses(User $instructor): Collection
    {
        return $this->catalogService->getCoursesByAuthor($instructor, Course::$STATUSES);
    }
}
