<?php

namespace App\Http\Controllers\Client\Instructor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{

    /**
     * Display the instructor's dashboard.
     *
     * @return View
     */
    public function index(): View
    {
        return view('livewire.client.dashboard.instructor.index');
    }
}
