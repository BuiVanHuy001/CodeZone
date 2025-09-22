<?php

use App\Http\Controllers\Transaction\PaymentController;
use App\Livewire\Client\Cart\Index;
use \Illuminate\Support\Facades\Route;

Route::get('payment/{order}/{method}', [PaymentController::class, 'redirect'])->name('payment');
Route::get('vnpay-callback', [PaymentController::class, 'callback'])->name('payment.success');

Route::get('cart', Index::class)->name('cart.index');
