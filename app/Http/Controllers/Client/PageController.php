<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Course;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use SweetAlert2\Laravel\Swal;

class PageController extends Controller
{
	public function homePage(): Factory|Application|View
	{
		return view('client.homepage');
	}

//	public function becomeOurTeacherPage(): Factory|Application|View
//	{
//		//
//	}

	public function notFoundPage(): Factory|Application|View
    {
		return view('client.404');
    }

    public function forbidden(): Factory|Application|View
    {
        return view('client.403');
    }

	public function maintenancePage(): Factory|Application|View
	{
		return view('client.maintenance');
	}

	public function courseDetail(Course $course): View|Application|Factory
	{
        $isReviewable = false;
        if (auth()->check()) {
            foreach (auth()->user()->batchEnrollments as $enrollment) {
                if ($enrollment->batch->course_id === $course->id) {
                    $isReviewable = $enrollment->batch->course
                        ->where('id', $course->id)
                        ->exists();
                    break;
                }
            }
        }
        return view('client.course-details', ['course' => $course, 'isReviewable' => $isReviewable]);
	}
}
