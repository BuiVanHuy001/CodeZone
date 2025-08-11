<?php

use App\Http\Middleware\EnsureUserIsOrganization;
use App\Livewire\Client\Organization\Dashboard\Courses;
use App\Livewire\Client\Organization\Dashboard\Members;
use App\Livewire\Client\Organization\Dashboard\OverView;
use App\Livewire\Client\Organization\Dashboard\Settings;
use App\Livewire\Client\CourseCreation\Index as CourseCreation;
use Illuminate\Support\Facades\Route;

Route::middleware(EnsureUserIsOrganization::class)->prefix('organization/dashboard')->group(function () {
    Route::get('/create-course', CourseCreation::class)->name('organization.courses.create');
    Route::get('/overview', OverView::class)->name('organization.dashboard.overview');
    Route::get('/members', Members::class)->name('organization.dashboard.members');
    Route::get('/courses', Courses::class)->name('organization.dashboard.courses');
    Route::get('/settings', Settings::class)->name('organization.dashboard.settings');
});
