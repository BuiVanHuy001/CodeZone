<?php

use App\Http\Controllers\Transaction\PaymentController;
use \Illuminate\Support\Facades\Route;

Route::get('payment/{order}/{method}', [PaymentController::class, 'redirect'])->name('payment');
