<?php

use App\Http\Middleware\EnsureUserIsStudent;
use App\Livewire\Client\Student\CoursesDashboard;
use App\Livewire\Client\Student\IndexDashboard;
use App\Livewire\Client\Student\ReviewsDashboard;
use Illuminate\Support\Facades\Route;

Route::middleware(EnsureUserIsStudent::class)->prefix('student/dashboard')->group(function () {
    Route::get('/overview', IndexDashboard::class)->name('student.dashboard.index');
    Route::get('/courses', CoursesDashboard::class)->name('student.dashboard.courses');
    Route::get('/reviews', ReviewsDashboard::class)->name('student.dashboard.reviews');
});
