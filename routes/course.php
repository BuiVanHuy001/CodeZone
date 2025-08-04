<?php

use App\Http\Controllers\Client\PageController;
use App\Http\Controllers\Client\Student\ReviewController;
use App\Livewire\Client\Lesson\Index;
use Illuminate\Support\Facades\Route;

Route::get('/course/{course:slug}', [PageController::class, 'courseDetail'])->name('page.course_detail');
Route::get('/course/{course:slug}/learn/{module:id?}/{lesson:id?}', Index::class)->name('course.learn');
