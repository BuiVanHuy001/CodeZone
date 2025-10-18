<?php

use App\Http\Controllers\Client\Student\CourseController;
use App\Http\Middleware\EnsureUserIsLogin;
use Illuminate\Support\Facades\Route;

Route::prefix('course')->group(function () {
    Route::get('{slug}', [CourseController::class, 'show'])
        ->name('page.course_detail');

    Route::middleware(EnsureUserIsLogin::class)->group(function () {
        Route::get('{slug}/learn', [CourseController::class, 'learn'])
            ->name('course.learn');
        Route::get('{slug}/learn/lesson/{id}', [CourseController::class, 'showLesson'])
            ->name('course.learn.lesson');
    });
});

Route::prefix('courses')->group(function () {
    Route::get('/', [CourseController::class, 'index'])
        ->name('page.courses');
});
