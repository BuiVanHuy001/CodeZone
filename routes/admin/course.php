<?php

use App\Http\Middleware\EnsureUserIsAdmin;
use Illuminate\Support\Facades\Route;

Route::middleware(EnsureUserIsAdmin::class)->group(function () {
    Route::prefix('admin')->group(function () {
        Route::get('courses')->name('admin.courses.index');
    });
});
