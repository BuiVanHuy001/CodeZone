<?php

namespace App\Services\Payment\Context;

use App\Services\Payment\Strategies\VNPayStrategies;

class PaymentContext {
    protected VNPayStrategies $strategy;

    public function __construct($strategy)
    {
        $this->strategy = $this->makeContext($strategy);
    }

    public function createPaymentUrl(array $params): string
    {
        return $this->strategy->createPaymentUrl($params);
    }

    public function handleCallback(array $data): mixed
    {
        return $this->strategy->handleCallback($data);
    }

    private function makeContext(string $gateway): VNPayStrategies
    {
        return match ($gateway) {
            'vnpay' => new VNPayStrategies(),
            default => throw new \InvalidArgumentException("Unsupported payment gateway: {$gateway}"),
        };
    }
}
