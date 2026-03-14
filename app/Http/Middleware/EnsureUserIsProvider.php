<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Provider;

class EnsureUserIsProvider
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check() || Auth::user()->user_type !== 'provider') {
            return redirect('/')->with('error', 'You do not have access to this section.');
        }

        $provider = Provider::where('user_id', Auth::id())->first();

        if (!$provider) {
            return redirect()->route('provider.create');
        }

        if ($provider->status !== 'active') {
            return redirect()->route('provider.pending');
        }

        return $next($request);
    }
}
