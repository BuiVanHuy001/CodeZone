<?php

namespace App\Services\Payment\Contracts;

use App\Models\Order;

interface PaymentGateWayInterface {
    public function createPaymentUrl(Order $order, string $method): string;

    public function handleCallback(array $data): mixed;
}
