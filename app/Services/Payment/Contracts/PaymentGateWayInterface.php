<?php

namespace App\Services\Payment\Contracts;

use App\Models\Order;

interface PaymentGateWayInterface {
    public function createPaymentUrl(Order $order);

    public function handleCallback(array $data): mixed;
}
