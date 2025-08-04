<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Course;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;

class PageController extends Controller
{
    public function homePage(): Factory|Application|View
    {
        return view('client.pages.homepage');
    }

    public function notFoundPage(): Factory|Application|View
    {
        return view('client.errors.404');
    }

    public function forbidden(): Factory|Application|View
    {
        return view('client.errors.403');
    }

    public function maintenancePage(): Factory|Application|View
    {
        return view('client.errors.maintenance');
    }

    public function courseDetail(Course $course): View|Application|Factory
    {
        $isReviewable = false;
        $reviews = $course->reviews()->with('user')->latest()->get();

        return view('client.pages.course-details', [
            'course' => $course,
            'reviews' => $reviews,
        ]);
    }
}
