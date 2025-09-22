<?php

namespace App\Http\Controllers\Auth\Socialite;

use App\Http\Controllers\Controller;
use App\Services\SocialLogin\Context\SocialLoginContext;
use App\Services\SocialLogin\Strategies\FacebookLoginStrategy;
use App\Services\SocialLogin\Strategies\GoogleLoginStrategy;
use Illuminate\Http\RedirectResponse;

class SocialiteController extends Controller
{
    public function redirect(string $provider): RedirectResponse
    {
        return (new SocialLoginContext($provider))->redirectToProvider();
    }

    public function callback(string $provider): RedirectResponse
    {
        return (new SocialLoginContext($provider))->handleCallback();
    }
}
