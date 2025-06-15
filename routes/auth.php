<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;

Route::get('login', [LoginController::class, 'showLoginForm'])->name('client.login');
Route::post('login', [LoginController::class, 'login'])->name('login.post');
Route::delete('logout', [LogoutController::class, 'logout'])->name('client.logout');
Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('client.register');
Route::post('register', [RegisterController::class, 'studentRegister'])->name('student.register.post');
