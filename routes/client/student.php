<?php

use App\Http\Middleware\EnsureUserIsStudent;
use App\Livewire\Client\Cart\Index;
use App\Livewire\Client\Student\Dashboard\Courses;
use App\Livewire\Client\Student\Dashboard\Overview;
use App\Livewire\Client\Student\Dashboard\Profile;
use App\Livewire\Client\Student\Dashboard\Purchases;
use App\Livewire\Client\Student\Dashboard\Reviews;
use App\Livewire\Client\Student\Dashboard\Settings;
use Illuminate\Support\Facades\Route;

Route::middleware(EnsureUserIsStudent::class)->prefix('student/dashboard')->group(function () {
    Route::get('/overview', Overview::class)->name('student.dashboard.index');
    Route::get('/courses', Courses::class)->name('student.dashboard.courses');
    Route::get('/profile', Profile::class)->name('student.dashboard.profile');
    Route::get('/reviews', Reviews::class)->name('student.dashboard.reviews');
    Route::get('/purchases', Purchases::class)->name('student.dashboard.purchases');
    Route::get('/settings', Settings::class)->name('student.dashboard.settings');
});

Route::get('cart', Index::class)->name('cart.index');
