<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\StudentRequest;
use App\Models\User;
use App\Traits\HasSlug;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    use HasSlug;

    public function showRegistrationForm(): \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\View
    {
        return view('client.register');
    }

    public function studentRegister(StudentRequest $request): RedirectResponse
    {
        $validatedData = $request->validated();

        $user = User::create([
            ...$validatedData,
            'slug' => $this->generateUniqueSlug($validatedData['name'], new User()),
        ]);

        auth()->login($user);
        return redirect()->route('page.home')->with('success', 'Registration successful!');
    }
}
