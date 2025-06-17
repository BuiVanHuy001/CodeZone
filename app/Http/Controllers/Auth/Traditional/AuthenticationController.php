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
        return view('client.register');
    }

    public function login(): RedirectResponse
    {
        return $this->authService->login();
    }

    public function showLoginForm(): Factory|Application|View
    {
        return view('client.login');
    }


    public function studentRegister(StudentRequest $request): RedirectResponse
    {
        return $this->authService->studentRegister($request);
    }

    public function logout(): RedirectResponse
    {
        return $this->authService->logout();
    }
}
