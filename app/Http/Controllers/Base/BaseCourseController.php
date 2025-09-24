<?php

namespace App\Http\Controllers\Base;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Services\CourseLearn\CourseService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

class BaseCourseController extends Controller
{
    protected CourseService $courseService;

    public function __construct()
    {
        $this->courseService = new CourseService();
    }

    public function show(Course $course): View|Application|Factory
    {
        $reviews = $course->reviews()->with('user')->latest()->get();
        $canAccess = $this->courseService->canAccess($course);

        return view('client.pages.course-details', compact('course', 'reviews', 'canAccess'));
    }
}
