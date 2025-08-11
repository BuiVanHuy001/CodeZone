<?php

use App\Http\Controllers\Client\PageController;
use Illuminate\Support\Facades\Route;

require __DIR__ . '/auth.php';
require __DIR__ . '/instructor.php';
require __DIR__ . '/organization.php';
require __DIR__ . '/student.php';
require __DIR__ . '/course.php';

Route::get('/', [PageController::class, 'homePage'])->name('page.home');
Route::get('/not-found', [PageController::class, 'notFoundPage'])->name('page.not_found');
Route::get('/forbidden', [PageController::class, 'forbidden'])->name('page.forbidden');
Route::get('/maintenance', [PageController::class, 'maintenancePage'])->name('page.maintenance');
Route::fallback(fn() => redirect()->route('page.not_found'));
