<?php

use App\Http\Controllers\Client\PageController;
use App\Http\Controllers\Client\Student\ReviewController;
use Illuminate\Support\Facades\Route;

Route::get('/course/{course:slug}', [PageController::class, 'courseDetail'])->name('page.course_detail');
Route::get('/course/{course:slug}/learn/{module:id?}/{lesson:id?}', \App\Livewire\Client\Lesson\Index::class)->name('course.learn');


Route::post('/review/{reviewable_type}/{reviewable_id}', [ReviewController::class, 'store'])
    ->name('course.review.store')
    ->middleware('auth');

