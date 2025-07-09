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

	public function maintenancePage(): Factory|Application|View
	{
		return view('client.maintenance');
	}

	public function courseDetail(Course $course): View|Application|Factory
	{
		return view('client.course-details', ['course' => $course,]);
	}
}
