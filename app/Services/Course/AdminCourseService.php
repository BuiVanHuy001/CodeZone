<?php

namespace App\Services\Course;

use App\Models\Course;
use App\Services\Course\Catalog\CatalogService;

readonly class AdminCourseService
{
    private CatalogService $catalogService;

    public function __construct()
    {
        $this->catalogService = app(CatalogService::class);
    }

    public function prepareDataForCourseList(): array
    {
        $result = [];

        if (auth()->check() && auth()->user()->isAdmin()) {
            foreach (Course::$STATUSES as $status) {
                $courses = $this->catalogService->getCoursesByStatus($status);
                $result[$status] = $courses;
            }
        }

        return $result;
    }
}
