<?php

namespace App\Services\TraditionalLogin;

use App\Http\Requests\StudentRequest;
use App\Mail\PasswordResetMail;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthenticationService {
    public function studentRegister(StudentRequest $request): RedirectResponse
    {
        $validatedData = $request->validated();

        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password'])
        ]);

        $user->assignRole('student');

        auth()->login($user);
        $request->session()->regenerate();

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

        request()->session()->invalidate();
        request()->session()->regenerateToken();

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
            $user = auth()->user();
            if ($user->status === 'active') {
                if ($user->hasRole('admin')) {
                    return redirect()->route('admin.overview.index')->with('swal', [
                        'title' => 'Login Successful',
                        'text' => 'Welcome back, Admin!',
                        'icon' => 'success',
                    ]);
                }

                return redirect()->intended()->with('swal', [
                    'title' => 'Login Successful',
                    'text' => 'Welcome back!',
                    'icon' => 'success',
                ]);
            }
            auth()->logout();
            return back()
                ->with('swal', [
                    'title' => 'Account Inactive',
                    'text' => 'Your account is not active. Please contact support.',
                    'icon' => 'error',
                ])
                ->withErrors(['email' => 'Your account is not active. Please contact support.'])
                ->withInput();
        }

        return back()
            ->withErrors(['email' => 'Your credential is incorrect.'])
            ->withInput();
    }

    public function resetPassword(User $user): void
    {
        $newPassword = substr(str_shuffle(
            'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()-_=+[]{};:,.<>?'
        ), 0, 12);

        $user->update([
            'password' => Hash::make($newPassword),
        ]);

        Mail::to($user->email)->send(new PasswordResetMail($user, $newPassword));
    }

    public function changePassword(string $newPassword): bool
    {
        return auth()->user()->update([
            'password' => Hash::make($newPassword),
        ]);
    }
}
