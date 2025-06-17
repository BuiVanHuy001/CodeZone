<?php

namespace App\Services\TraditionalLogin;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use SweetAlert2\Laravel\Swal;

class AuthenticationService
{
    public function studentRegister($request): RedirectResponse
    {
        $validatedData = $request->validated();

        $user = User::create(['name' => $validatedData['name'], 'email' => $validatedData['email'], 'password' => bcrypt($validatedData['password']),]);

        auth()->login($user);
        return redirect()->route('page.home')->with('sweetalert2', 'Registration successful!');
    }

    public function logout(): RedirectResponse
    {
        auth()->logout();
        return redirect()->route('page.home')->with('sweetalert2', 'Logout successful!');
    }

public function login(): RedirectResponse
{
    $request = request();
    $data = $request->all();

    if (isset($data['email']) && !str_contains($data['email'], '@')) {
        $data['email'] .= '@codezone.com';
        $request->merge(['email' => $data['email']]);
    }

    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => 'required|min:8',
    ]);

    if (auth()->attempt($credentials)) {
        return redirect()->intended()->with('sweetalert2', 'Login successful!');
    }

    return back()->withErrors(['email' => 'The provided credentials do not match our records.'])->withInput();
}
}
