<?php

namespace App\Http\Controllers\Client\Instructor;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\Instructor\InstructorService;

class InstructorController extends Controller
{
    public function show(User $instructor, InstructorService $instructorService)
    {
        try {
            $instructor = $instructorService->prepareDetails($instructor);
            return view('client.pages.instructor-profile', compact('instructor'));
        } catch (\Exception $exception) {
            dd($exception);
            return view('client.errors.404');
        }
    }
}
