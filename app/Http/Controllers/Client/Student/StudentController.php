<?php

namespace App\Http\Controllers\Client\Student;

use App\Models\User;
use App\Services\Student\StudentService;

class StudentController
{
    private StudentService $studentService;

    public function __construct()
    {
        $this->studentService = app(StudentService::class);
    }

    public function show(string $slug)
    {
        $student = User::where([
            'slug' => $slug,
            'role' => 'student',
            'status' => 'active',
        ])->first();

        if (!$student) {
            return view('client.errors.404');
        }
        $student = $this->studentService->prepareDetails($student);

        return view('client.pages.student-profile', compact('student'));
    }
}
