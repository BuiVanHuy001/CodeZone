<?php

use App\Http\Middleware\EnsureUserIsBusiness;
use App\Http\Middleware\EnsureUserIsInstructor;
use App\Livewire\Client\Business\EmployeesDashboard;
use App\Livewire\Client\Business\IndexDashboard as BusinessIndexDashboard;
use App\Livewire\Client\CreateCourse;
use App\Livewire\Client\Instructor\CoursesDashboard;
use App\Livewire\Client\Business\CoursesDashboard as BusinessCoursesDashboard;
use App\Livewire\Client\Instructor\IndexDashboard;
use App\Livewire\Client\Instructor\ProfileDashboard;
use App\Livewire\Client\Instructor\ReviewsDashboard;
use App\Livewire\Client\Instructor\SettingsDashboard;
use Illuminate\Support\Facades\Route;

Route::middleware(EnsureUserIsInstructor::class)->group(function () {
    Route::get('instructor/dashboard', IndexDashboard::class)->name('instructor.dashboard.index');

    Route::get('instructor/dashboard/profile', ProfileDashboard::class)->name('instructor.dashboard.profile');

    Route::get('instructor/dashboard/courses', CoursesDashboard::class)->name('instructor.dashboard.courses');

    Route::get('instructor/dashboard/reviews', ReviewsDashboard::class)->name('instructor.dashboard.reviews');

    Route::get('instructor/dashboard/settings', SettingsDashboard::class)->name('instructor.dashboard.settings');

    Route::get('instructor/dashboard/create-course', CreateCourse::class)->name('instructor.courses.create');
});

Route::middleware(EnsureUserIsBusiness::class)->prefix('business/dashboard')->group(function () {
    Route::get('/create-course', CreateCourse::class)->name('business.courses.create');
    Route::get('/index', BusinessIndexDashboard::class)->name('business.dashboard.index');
	Route::get('/employees', EmployeesDashboard::class)->name('business.dashboard.employees');
	Route::get('/courses', BusinessCoursesDashboard::class)->name('business.dashboard.courses');
});
