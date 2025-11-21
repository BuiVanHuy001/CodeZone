<?php

namespace App\Services\Client\Instructor;

use App\Models\User;
use App\Services\Client\Course\CourseService;
use App\Services\Client\Instructor\Catalog\CatalogService;
use App\Traits\HasNumberFormat;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Spatie\Permission\Models\Role;

readonly class InstructorService {
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
        $cacheKey = "instructor_detail_{$slug}";

        return Cache::remember($cacheKey, now()->addHours(2), function () use ($slug) {
            $instructor = Role::findByName('instructor')->users()
                              ->where([
                                  'slug' => $slug,
                                  'status' => 'active'
                              ])->first();

            if ($instructor) {
                return $this->catalogService->getDetails($instructor);
            }

            return null;
        });

    }

    public function prepareDetails(User $instructor): User
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
