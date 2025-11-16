<?php

use App\Http\Controllers\Client\PageController;
use Illuminate\Support\Facades\Route;

require __DIR__ . '/client/auth.php';
require __DIR__ . '/client/instructor.php';
require __DIR__ . '/client/student.php';
require __DIR__ . '/client/course.php';
require __DIR__ . '/client/payment.php';
require __DIR__ . '/admin/admin.php';

Route::get('/', [PageController::class, 'homePage'])->name('page.home');
Route::get('/not-found', [PageController::class, 'notFoundPage'])->name('page.not_found');
Route::get('/forbidden', [PageController::class, 'forbidden'])->name('page.forbidden');
Route::get('/maintenance', [PageController::class, 'maintenancePage'])->name('page.maintenance');
Route::fallback(static function () {
    if (auth()->user()->hasRole('admin')) {
        return view('admin.errors.404');
    }
    return view('client.errors.404');
});
