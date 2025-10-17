<?php

namespace App\Http\Controllers\Base;

use App\Http\Controllers\Controller;
use App\Services\Course\CourseService;
use App\Services\Course\LearningService;
use App\Support\CourseFilter;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class BaseCourseController extends Controller
{
    protected LearningService $learningService;
    protected CourseService $courseService;

    public function __construct()
    {
        $this->learningService = app(LearningService::class);
        $this->courseService = app(CourseService::class);
    }

    public function show(string $slug): View|Application|Factory
    {
        $course = $this->courseService->prepareDataForCourseDetails($slug);

        if (!$course) {
            return view('client.errors.404');
        }

        return view('client.pages.course-details', [
            'course' => $course,
            'canAccess' => Gate::allows('access', $course),
        ]);
    }

    public function index(Request $request): View|Application|Factory
    {
        $data = $this->courseService->prepareDataForCourseList($request);

        return view('client.pages.course-list', [
            'courses' => $data['courses'],
            'instructors' => $data['instructors'],
            'categories' => $data['categories'],
            'shortByOptions' => CourseFilter::$shortByOptions,
            'offsetOptions' => CourseFilter::$offerOptions,
        ]);
    }
}
