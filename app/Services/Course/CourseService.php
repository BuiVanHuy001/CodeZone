<?php

namespace App\Services\Course;


use App\Models\Course;
use App\Models\User;
use App\Services\Course\Catalog\CatalogService;
use App\Services\Course\Create\CreateService;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

readonly class CourseService
{
    private CatalogService $catalogService;
    private CreateService $createService;

    public function __construct()
    {
        $this->catalogService = app(CatalogService::class);
        $this->createService = app(CreateService::class);
    }

    public function prepareDataForCourseList(Request $request): Collection
    {
        return $this->catalogService->prepareCourseList(9, $request);
    }

    public function prepareDataForCourseDetails(string $slug): ?Course
    {
        $course = Course::where([
            'slug' => $slug,
            'status' => 'published'
        ])->first();

        if ($course) {
            return $this->catalogService->prepareCourseDetails($course);
        }

        return null;
    }

    public function storeCourse(User $author, array $courseData): void
    {
        $this->createService->storeCourse($author, $courseData);
    }
}
