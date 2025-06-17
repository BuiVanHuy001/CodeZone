<?php

use App\Http\Controllers\Client\Instructor\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('dashboard', [DashboardController::class, 'index'])
    ->name('instructor.dashboard.index');
