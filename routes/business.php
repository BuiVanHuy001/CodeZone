<?php

use App\Http\Middleware\EnsureUserIsBusiness;
use App\Livewire\Client\Business\CoursesDashboard;
use App\Livewire\Client\Business\EmployeesDashboard;
use App\Livewire\Client\Business\IndexDashboard;
use App\Livewire\Client\Business\SettingDashboard;
use App\Livewire\Client\CreateCourse;
use Illuminate\Support\Facades\Route;

Route::middleware(EnsureUserIsBusiness::class)->prefix('business/dashboard')->group(function () {
    Route::get('/create-course', CreateCourse::class)->name('business.courses.create');
    Route::get('/overview', IndexDashboard::class)->name('business.dashboard.index');
    Route::get('/employees', EmployeesDashboard::class)->name('business.dashboard.employees');
    Route::get('/courses', CoursesDashboard::class)->name('business.dashboard.courses');
	Route::get('/settings', SettingDashboard::class)->name('business.dashboard.settings');
});
