<?php

namespace App\Services\SocialLogin\Context;

use App\Services\SocialLogin\Contracts\SocialLoginStrategyInterface;
use App\Services\SocialLogin\Strategies\FacebookLoginStrategy;
use App\Services\SocialLogin\Strategies\GoogleLoginStrategy;
use Illuminate\Http\RedirectResponse;

class SocialLoginContext
{
    protected SocialLoginStrategyInterface $strategy;

    public function __construct($strategy)
    {
        $this->strategy = $this->makeContext($strategy);
    }

    public function redirectToProvider(): RedirectResponse
    {
        return $this->strategy->redirectToProvider();
    }

    public function handleCallback(): RedirectResponse
    {
        return $this->strategy->handleCallback();
    }

    private function makeContext(string $provider): GoogleLoginStrategy|FacebookLoginStrategy
    {
        return match ($provider) {
            'google' => new GoogleLoginStrategy(),
            'facebook' => new FacebookLoginStrategy(),
        };
    }
}
