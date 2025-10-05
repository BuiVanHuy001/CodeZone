<?php

use App\Http\Controllers\Transaction\PaymentController;
use \Illuminate\Support\Facades\Route;

Route::get('payment/{order}/{method}', [PaymentController::class, 'redirect'])->name('payment');

Route::get('payment-callback/{method}', [PaymentController::class, 'callback'])->name('payment.success');
