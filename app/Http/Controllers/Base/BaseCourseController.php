<?php

namespace App\Http\Controllers\Base;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Services\Course\CatalogService;
use App\Services\Course\LearningService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Gate;

class BaseCourseController extends Controller
{
    protected LearningService $learningService;
    protected CatalogService $catalogService;

    public function __construct()
    {
        $this->learningService = app(LearningService::class);
        $this->catalogService = app(CatalogService::class);
    }

    public function show(string $slug): View|Application|Factory
    {
        $course = Course::where([
            'slug' => $slug,
            'status' => 'published'
        ])->first();

        if ($course) {
            $course = $this->catalogService->prepareDetails($course);
            $canAccess = Gate::allows('access', $course);
            return view('client.pages.course-details',
                compact('course', 'canAccess'));
        }

        return view('client.errors.404');
    }
}
