<?php

namespace App\Services\Payment\Contracts;

use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;

interface PaymentGateWayInterface {
    public function createPaymentUrl(Order $order);

    public function handleCallback(array $data): Redirector|RedirectResponse;
}
