<?php

use App\Http\Middleware\EnsureUserIsAdmin;
use App\Livewire\Admin\Courses\Index as CoursesIndex;
use App\Livewire\Admin\Overview\Index as OverviewIndex;
use \Illuminate\Support\Facades\Route;

Route::middleware(EnsureUserIsAdmin::class)->group(function () {
    Route::prefix('admin')->group(function () {
        Route::get('/', OverviewIndex::class)->name('admin.overview.index');
        Route::get('/courses', CoursesIndex::class)->name('admin.courses.index');
    });
});
