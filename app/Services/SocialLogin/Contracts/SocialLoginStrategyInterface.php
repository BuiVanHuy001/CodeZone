<?php

namespace App\Services\SocialLogin\Contracts;

use Illuminate\Http\RedirectResponse;

interface SocialLoginStrategyInterface
{
    public function redirectToProvider(): RedirectResponse;

    public function handleCallback(): RedirectResponse;

}
