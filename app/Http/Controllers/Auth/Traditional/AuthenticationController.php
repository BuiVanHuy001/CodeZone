<?php

namespace App\Http\Controllers\Auth\Traditional;

use App\Http\Requests\StudentRequest;
use App\Services\TraditionalLogin\AuthenticationService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;

class AuthenticationController
{
    private AuthenticationService $authService;

    public function __construct()
    {
        $this->authService = new AuthenticationService();
    }

    public function showRegistrationForm(): Factory|Application|View
    {
	    return view('client.auth.register');
    }

    public function login(): RedirectResponse
    {
        return $this->authService->login();
    }

    public function showLoginForm(?string $userEmail = null): Factory|Application|View
    {
        return view('client.auth.login', ['email' => $userEmail]);
    }

    public function studentRegister(StudentRequest $request): RedirectResponse
    {
        return $this->authService->studentRegister($request);
    }

    public function logout(): RedirectResponse
    {
        dd('here');
        return $this->authService->logout();
    }

    public function showForgotPasswordForm(): Factory|Application|View
    {
        return view('client.auth.forgot-password');
    }
}
