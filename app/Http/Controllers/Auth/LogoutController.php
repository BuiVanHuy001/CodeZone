<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use SweetAlert2\Laravel\Swal;

class LogoutController extends Controller
{
    public function logout(): \Illuminate\Http\RedirectResponse
    {
        auth()->logout();
        Swal::success([
            'title' => 'You have been logged out successfully!',
            'icon' => 'success',
        ]);
        return redirect()->route('page.home');
    }
}
