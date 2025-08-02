<?php

use App\Http\Controllers\Client\PageController;
use Illuminate\Support\Facades\Route;

require __DIR__.'/auth.php';
require __DIR__.'/instructor.php';
require __DIR__ . '/business.php';
require __DIR__ . '/student.php';
require __DIR__ . '/course.php';

Route::get('/', [PageController::class, 'homePage'])->name('page.home');
// Route::get('/become-our-teacher', [PageController::class, 'becomeOurTeacherPage'])->name('page.become_our_teacher');
Route::get('/not-found', [PageController::class, 'notFoundPage'])->name('page.not_found');
Route::get('/forbidden', [PageController::class, 'forbidden'])->name('page.forbidden');
Route::get('/maintenance', [PageController::class, 'maintenancePage'])->name('page.maintenance');
Route::fallback(fn() => redirect()->route('page.not_found'));
Route::get('test', function () {
    return redirect()->route('page.home')->with('swal', [
        'title' => 'Test',
        'text' => 'This is a test alert.',
        'icon' => 'info',
    ]);
})->name('test');
