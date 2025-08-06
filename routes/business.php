<?php

use App\Http\Middleware\EnsureUserIsBusiness;
use App\Livewire\Client\Business\Dashboard\Courses;
use App\Livewire\Client\Business\Dashboard\Employees;
use App\Livewire\Client\Business\Dashboard\OverView;
use App\Livewire\Client\Business\Dashboard\Settings;
use App\Livewire\Client\CourseCreation\Index as CourseCreation;
use Illuminate\Support\Facades\Route;

Route::middleware(EnsureUserIsBusiness::class)->prefix('business/dashboard')->group(function () {
	Route::get('/create-course', CourseCreation::class)->name('business.courses.create');
    Route::get('/overview', OverView::class)->name('business.dashboard.index');
    Route::get('/employees', Employees::class)->name('business.dashboard.employees');
    Route::get('/courses', Courses::class)->name('business.dashboard.courses');
	Route::get('/settings', Settings::class)->name('business.dashboard.settings');
});
