<?php

namespace App\Services\Payment\Context;

use App\Services\Payment\Strategies\MomoStrategy;
use App\Services\Payment\Strategies\VNPayStrategy;
use Illuminate\Http\RedirectResponse;

class PaymentContext {
    protected VNPayStrategy|MomoStrategy $strategy;

    public function __construct($strategy)
    {
        $this->strategy = $this->makeContext($strategy);
    }

    public function createPaymentUrl(array $params): RedirectResponse
    {
        return $this->strategy->createPaymentUrl($params['order']);
    }

    public function handleCallback(array $data): mixed
    {
        return $this->strategy->handleCallback($data);
    }

    private function makeContext(string $gateway): VNPayStrategy|MomoStrategy
    {
        return match ($gateway) {
            'vnpay' => new VNPayStrategy(),
            'momo' => new MomoStrategy(),
            default => throw new \InvalidArgumentException("Unsupported payment gateway: {$gateway}"),
        };
    }
}
