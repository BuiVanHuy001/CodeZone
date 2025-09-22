<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\Payment\Context\PaymentContext;

class PaymentController extends Controller
{
    public function redirect(Order $order, string $method): string
    {
        dd($order, $method);
        return (new PaymentContext($method))->createPaymentUrl(request()->all());
    }
}
