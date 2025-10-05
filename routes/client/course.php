<?php

use App\Http\Controllers\Client\Student\CourseController;
use Illuminate\Support\Facades\Route;


Route::prefix('course')->group(function () {
    Route::get('{slug}', [CourseController::class, 'show'])
        ->name('page.course_detail');

    Route::get('{slug}/learn', [CourseController::class, 'index'])
        ->name('course.learn');

    Route::get('{slug}/learn/lesson/{id}', [CourseController::class, 'showLesson'])
        ->name('course.learn.lesson');
});
