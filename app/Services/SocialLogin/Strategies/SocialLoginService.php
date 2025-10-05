<?php

namespace App\Services\SocialLogin\Strategies;

use App\Models\User;
use App\Services\SocialLogin\Contracts\SocialLoginStrategyInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Laravel\Socialite\Facades\Socialite;
use SweetAlert\Swal;

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
                    'avatar' => $user->getAvatar(),
                ]
            );

            if ($authUser->wasRecentlyCreated && $user->getAvatar()) {
                $imageContent = file_get_contents($user->getAvatar());
                if ($imageContent !== false) {
                    $filename = uniqid('', true) . '.jpg';
                    Storage::disk('public')->put('avatars/' . $filename, $imageContent);

                    $authUser->update(['avatar' => $filename]);
                }
            }

            auth()->login($authUser, true);

            return redirect()->intended()->with('swal', [
                'title' => 'Login Successful',
                'text' => 'Welcome back, ' . $authUser->name . '!',
                'icon' => 'success',
            ]);

        } catch (\Exception $e) {
            if (!auth()->check()) {
                Swal::error([
                    'title' => 'Login Failed with ' . $this->provider,
                    'text' => 'Please try again.',
                ]);
            }
            return redirect()->route('page.home')
                ->withErrors(['error' => 'Failed to login with ' . $this->provider]);
        }
    }
}
