<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureUserIsDriver
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check() || Auth::user()->user_type !== 'driver') {
            return redirect('/')->with('error', 'You do not have access to this section.');
        }

        return $next($request);
    }
}
