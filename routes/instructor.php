<?php

use App\Http\Middleware\EnsureUserIsInstructor;
use App\Livewire\Client\CourseCreation\Index as CourseCreation;
use App\Livewire\Client\Instructor\Dashboard\Courses;
use App\Livewire\Client\Instructor\Dashboard\Overview;
use App\Livewire\Client\Instructor\Dashboard\Profile;
use App\Livewire\Client\Instructor\Dashboard\Reviews;
use App\Livewire\Client\Instructor\Dashboard\Settings;
use Illuminate\Support\Facades\Route;

Route::middleware(EnsureUserIsInstructor::class)->group(function () {
    Route::prefix('instructor/dashboard')->group(function () {
        Route::get('/overview', Overview::class)->name('instructor.dashboard.index');
        Route::get('/courses', Courses::class)->name('instructor.dashboard.courses');
        Route::get('/profile', Profile::class)->name('instructor.dashboard.profile');
        Route::get('/reviews', Reviews::class)->name('instructor.dashboard.reviews');
        Route::get('/settings', Settings::class)->name('instructor.dashboard.settings');
        Route::get('/create-builders', CourseCreation::class)->name('instructor.courses.create');
    });
});
