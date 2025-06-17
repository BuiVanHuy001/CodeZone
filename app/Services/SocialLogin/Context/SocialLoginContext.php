<?php

namespace App\Services\SocialLogin\Context;

use App\Services\SocialLogin\Contracts\SocialLoginStrategyInterface;
use Illuminate\Http\RedirectResponse;

class SocialLoginContext
{
    protected SocialLoginStrategyInterface $strategy;

    public function __construct($strategy)
    {
        $this->strategy =  $strategy;
    }

    public function redirectToProvider(): RedirectResponse
    {
        return $this->strategy->redirectToProvider();
    }

    public function handleCallback(): RedirectResponse
    {
        return $this->strategy->handleCallback();
    }
}
