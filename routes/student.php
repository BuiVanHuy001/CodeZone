<?php

use App\Http\Middleware\EnsureUserIsStudent;
use App\Livewire\Client\Student\Dashboard\Courses;
use App\Livewire\Client\Student\Dashboard\Overview;
use App\Livewire\Client\Student\Dashboard\Reviews;
use Illuminate\Support\Facades\Route;

Route::middleware(EnsureUserIsStudent::class)->prefix('student/dashboard')->group(function () {
    Route::get('/overview', Overview::class)->name('student.dashboard.index');
    Route::get('/courses', Courses::class)->name('student.dashboard.courses');
    Route::get('/reviews', Reviews::class)->name('student.dashboard.reviews');
});
