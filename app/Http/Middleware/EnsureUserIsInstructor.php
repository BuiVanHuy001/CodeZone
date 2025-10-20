<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsInstructor
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check() || !auth()->user()->isInstructor()) {
            return redirect()->route('page.forbidden');
        }
        return $next($request);
    }
}
