<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected function authenticated(Request $request, $user)
    {
        // Redirect unverified users to intended URL (verification link) or verification notice
        if (!$user->hasVerifiedEmail()) {
            return redirect()->intended(route('verification.notice'));
        }

        // Redirect based on user type
        // Provider approval is handled by the 'provider' middleware on provider routes
        if ($user->user_type == 'provider') {
            return redirect()->route('provider.dashboard');
        } elseif ($user->user_type == 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($user->user_type == 'driver') {
            return redirect()->route('driver.dashboard');
        } else {
            return redirect()->route('user.dashboard');
        }
    }

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function validateLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ], [
            'email.required' => 'The email field is required.',
            'email.email' => 'Please enter a valid email address.',
            'password.required' => 'The password field is required.',
        ]);
    }
}