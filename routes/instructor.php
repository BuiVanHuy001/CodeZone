<?php

use App\Http\Middleware\EnsureUserIsInstructor;
use App\Livewire\Client\CreateCourse;
use App\Livewire\Client\Instructor\CoursesDashboard;
use App\Livewire\Client\Instructor\IndexDashboard;
use App\Livewire\Client\Instructor\ProfileDashboard;
use App\Livewire\Client\Instructor\ReviewsDashboard;
use App\Livewire\Client\Instructor\SettingsDashboard;
use Illuminate\Support\Facades\Route;

Route::middleware(EnsureUserIsInstructor::class)->group(function () {
    Route::prefix('instructor/dashboard')->group(function () {
        Route::get('/overview', IndexDashboard::class)->name('instructor.dashboard.index');
        Route::get('/courses', CoursesDashboard::class)->name('instructor.dashboard.courses');
        Route::get('/profile', ProfileDashboard::class)->name('instructor.dashboard.profile');
        Route::get('/reviews', ReviewsDashboard::class)->name('instructor.dashboard.reviews');
        Route::get('/settings', SettingsDashboard::class)->name('instructor.dashboard.settings');
        Route::get('/create-course', CreateCourse::class)->name('instructor.courses.create');
    });
});
