<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\Payment\Context\PaymentContext;
use Illuminate\Http\RedirectResponse;
use Random\RandomException;

class PaymentController extends Controller
{
    /**
     * @throws RandomException
     */
    public function redirect(Order $order, string $method): RedirectResponse
    {
        return (new PaymentContext('momo'))->createPaymentUrl(['order' => $order,]);
    }

    public function callback()
    {
        dd(request()->all());
    }
}
