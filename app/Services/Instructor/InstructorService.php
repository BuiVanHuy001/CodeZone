<?php

namespace App\Services\Instructor;

use App\Models\Course;
use App\Models\OrderItem;
use App\Models\User;
use App\Services\Instructor\Catalog\CatalogService;
use App\Services\Course\CourseService;
use App\Traits\HasNumberFormat;
use Illuminate\Support\Collection;

readonly class InstructorService
{
    use HasNumberFormat;

    private CourseService $courseService;
    private CatalogService $catalogService;

    public function __construct()
    {
        $this->courseService = app(CourseService::class);
        $this->catalogService = app(CatalogService::class);
    }

    public function prepareDetailData(string $slug): ?User
    {
        $instructor = User::where([
            'slug' => $slug,
            'role' => 'instructor',
            'status' => 'active'
        ])->first();

        if ($instructor) {
            return $this->catalogService->getDetails($instructor);
        }

        return null;
    }

    public function prepareDetails(User $instructor): Collection
    {
        return $this->catalogService->getDetails($instructor);
    }

    public function prepareDetailForCourseDetail(User $instructor): User
    {
        return $this->catalogService->prepareDetailForCourseDetail($instructor);
    }

    public function prepareBasicDetails(User $instructor): User
    {
        return $this->catalogService->prepareBasicDetails($instructor);
    }

    public function prepareOverviewData(User $instructor): array
    {
        return $this->catalogService->getOverviewData($instructor);
    }

    public function getInstructors(): Collection
    {
        $instructors = User::where([
            'role' => 'instructor',
            'status' => 'active'])
            ->whereHas('instructorProfile', function ($query) {
                $query->where('course_count', '>', 0);
            })
            ->with('instructorProfile')
            ->get();
        return $instructors->sortByDesc(fn($instructor) => $instructor->instructorProfile->rating);
    }


    public function getInstructorCourses(User $instructor): Collection
    {
        return $this->courseService->getCoursesByAuthor($instructor);
    }
}
