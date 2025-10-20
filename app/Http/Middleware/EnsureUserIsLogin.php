<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsLogin
{
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check()) {
            return $next($request);
        }
        return redirect()->route('client.login')
            ->with('swal', [
                'icon' => 'error',
                'title' => 'You need to login first',
                'text' => 'Please login to access this page',
            ]);
    }
}
