@extends('layouts.app')

@section('content')
<div class="bg-surface min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full">
        <div class="bg-white border border-slate-100 rounded-md shadow-sm p-8">
            <div class="mb-6">
                <h2 class="text-2xl font-bold text-slate-900">Reset Password</h2>
                <p class="mt-1 text-sm text-slate-500">Enter your email and we'll send you a reset link.</p>
            </div>

            @if (session('status'))
                <div class="bg-emerald-50 border border-emerald-200 rounded-md p-3 mb-4">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle text-emerald-500 mr-2 text-sm"></i>
                        <p class="text-sm text-emerald-700">{{ session('status') }}</p>
                    </div>
                </div>
            @endif

            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 rounded-md p-3 mb-4">
                    <div class="flex items-start">
                        <i class="fas fa-exclamation-circle text-red-500 mr-2 text-sm mt-0.5"></i>
                        <div class="text-sm text-red-700">
                            @foreach ($errors->all() as $error)
                                {{ $error }}<br>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
                @csrf

                <div>
                    <label for="email" class="block text-sm font-medium text-slate-700 mb-1">Email Address</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                        class="w-full px-3 py-2 border border-slate-200 rounded-md text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors">
                </div>

                <button type="submit"
                    class="w-full flex justify-center py-2.5 px-4 bg-primary text-white text-sm font-medium rounded-md hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-colors">
                    Send Password Reset Link
                </button>

                <div class="text-center">
                    <a href="{{ route('login') }}" class="text-sm font-medium text-primary hover:text-primary-dark">
                        <i class="fas fa-arrow-left mr-1 text-xs"></i> Back to Login
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
