<?php

use App\Http\Controllers\Auth\Socialite\SocialiteController;
use App\Http\Controllers\Auth\Traditional\AuthenticationController;
use Illuminate\Support\Facades\Route;

Route::get('login', [AuthenticationController::class, 'showLoginForm'])
    ->name('client.login');
Route::post('login', [AuthenticationController::class, 'login'])
    ->name('login.post');
Route::delete('logout', [AuthenticationController::class, 'logout'])
    ->name('client.logout');
Route::get('register', [AuthenticationController::class, 'showRegistrationForm'])
    ->name('client.register');
Route::post('register', [AuthenticationController::class, 'studentRegister'])
    ->name('student.register.post');
Route::get('login-help', [AuthenticationController::class, 'showForgotPasswordForm'])
    ->name('client.forgot-password');

Route::get('auth/{provider}/redirect', [SocialiteController::class, 'redirect'])
    ->name('socialite.redirect');
Route::get('auth/{provider}/callback', [SocialiteController::class, 'callback'])
    ->name('socialite.callback');
