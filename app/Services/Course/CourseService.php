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
        $query = Course::query()->where('slug', $slug);
        if (!auth()->user()?->hasRole('admin')) {
            $query->where('status', 'published');
        }

        $course = $query->first();

        return $course ? $this->catalogService->prepareCourseDetails($course) : null;
    }

    public function getCoursesByAuthor(User $author): Collection
    {
        return $this->catalogService->getCoursesByAuthor($author);
    }

    public function getCoursesByStudent(User $student): Collection
    {
        return $this->catalogService->getCoursesByStudent($student);
    }

    public function storeCourse(User $author, array $courseData): void
    {
        $this->createService->storeCourse($author, $courseData);
    }
}
