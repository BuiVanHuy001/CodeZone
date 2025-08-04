<?php

namespace App\Services\TraditionalLogin;

use App\Models\User;
use Illuminate\Http\RedirectResponse;

class AuthenticationService
{
    public function studentRegister($request): RedirectResponse
    {
        $validatedData = $request->validated();

        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password'])
        ]);

        auth()->login($user);
        return redirect()
            ->route('page.home')
            ->with('swal', [
                'title' => 'Registration Successful',
                'text' => 'Welcome to CodeZone!',
                'icon' => 'success',
            ]);
    }

    public function logout(): RedirectResponse
    {
        auth()->logout();
        return redirect()
            ->route('page.home')
            ->with('swal', [
                'title' => 'Logout Successful',
                'text' => 'You have been logged out.',
                'icon' => 'success',
            ]);
    }

	public function login(): RedirectResponse
	{
        $data = request()->all();

		if (isset($data['email']) && !str_contains($data['email'], '@')) {
			$data['email'] .= '@codezone.com';
            request()->merge(['email' => $data['email']]);
		}

        $credentials = request()->validate([
            'email' => ['required', 'email'],
            'password' => 'required|min:8'
        ]);

		if (auth()->attempt($credentials)) {
            return redirect()->intended()->with('swal', [
                'title' => 'Login Successful',
                'text' => 'Welcome back to CodeZone!',
                'icon' => 'success',
            ]);
		}

        return back()->withErrors(['email' => 'Your credential is incorrect.'])
            ->withInput();
	}
}
