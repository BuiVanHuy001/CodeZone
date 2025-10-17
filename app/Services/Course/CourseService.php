<?php

namespace App\Services\Course;


use App\Models\Course;
use App\Services\Course\Catalog\CatalogService;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class CourseService
{
    private CatalogService $catalogService;

    public function __construct()
    {
        $this->catalogService = app(CatalogService::class);
    }

    public function prepareCatalogData(Request $request): Collection
    {
        return $this->catalogService->prepareCatalogData(9, $request);
    }

    public function prepareCourseDetailData(string $slug): ?Course
    {
        $course = Course::where([
            'slug' => $slug,
            'status' => 'published'
        ])->first();

        if ($course) {
            return $this->catalogService->prepareDetails($course);
        }

        return null;
    }
}
