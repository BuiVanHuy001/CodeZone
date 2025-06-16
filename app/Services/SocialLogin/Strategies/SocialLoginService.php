<?php

namespace App\Services\SocialLogin\Strategies;

use App\Models\User;
use App\Services\SocialLogin\Contracts\SocialLoginStrategyInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

abstract class SocialLoginService implements SocialLoginStrategyInterface
{
    public function redirectToProvider(): RedirectResponse
    {
        return Socialite::driver($this->provider)->redirect();
    }

    public function handleCallback(): RedirectResponse
    {
        try {
            $user = Socialite::driver($this->provider)->user();
            $authUser = User::firstOrCreate(
                ['email' => $user->getEmail()],
                [
                    'name' => $user->getName(),
                    'password' => Hash::make($user->getId()),
                    'avatar_url' => $user->getAvatar(),
                ]
            );

            auth()->login($authUser, true);

            return redirect()->intended()->with('sweetalert2', 'Logged in with ' . $this->provider);

        } catch (\Exception $e) {
            return redirect()->route('page.home')->withErrors(['error' => 'Failed to login with ' . $this->provider]);
        }
    }
}
