<?php

namespace App\Http\Controllers\Client\Instructor;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\Instructor\InstructorService;

class InstructorController extends Controller
{
    private InstructorService $instructorService;

    public function __construct()
    {
        $this->instructorService = app(InstructorService::class);
    }

    public function show(string $slug, InstructorService $instructorService)
    {
        $instructor = $this->instructorService->prepareDetailData($slug);
        if (!$instructor) {
            return view('client.errors.404');
        }

        return view('client.pages.instructor-profile', compact('instructor'));
    }
}
