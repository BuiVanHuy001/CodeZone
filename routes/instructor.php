<?php

use App\Livewire\Client\Instructor\CoursesDashboard;
use App\Livewire\Client\Instructor\IndexDashboard;
use App\Livewire\Client\Instructor\ProfileDashboard;
use App\Livewire\Client\Instructor\ReviewsDashboard;
use App\Livewire\Client\Instructor\SettingsDashboard;
use Illuminate\Support\Facades\Route;

Route::get('instructor/dashboard', IndexDashboard::class)
    ->name('instructor.dashboard.index');

Route::get('instructor/dashboard/profile', ProfileDashboard::class)
    ->name('instructor.dashboard.profile');

Route::get('instructor/dashboard/courses', CoursesDashboard::class)
    ->name('instructor.dashboard.courses');

Route::get('instructor/dashboard/reviews', ReviewsDashboard::class)
    ->name('instructor.dashboard.reviews');

Route::get('instructor/dashboard/settings', SettingsDashboard::class)
    ->name('instructor.dashboard.settings');

Route::get('instructor/create-course', \App\Livewire\Client\Instructor\CreateCourse::class)
    ->name('instructor.dashboard.create-course');
