<?php

use App\Http\Controllers\Client\PageController;
use Illuminate\Support\Facades\Route;

require __DIR__.'/auth.php';
require __DIR__.'/instructor.php';

Route::get('/', [PageController::class, 'homePage'])->name('page.home');
// Route::get('/become-our-teacher', [PageController::class, 'becomeOurTeacherPage'])->name('page.become_our_teacher');
Route::get('/not-found', [PageController::class, 'notFoundPage'])->name('page.not_found');
Route::get('/maintenance', [PageController::class, 'maintenancePage'])->name('page.maintenance');
