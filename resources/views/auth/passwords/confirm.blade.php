@extends('layouts.app')

@section('content')
<div class="bg-surface min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full">
        <div class="bg-white border border-slate-100 rounded-md shadow-sm p-8">
            <div class="text-center mb-6">
                <div class="w-14 h-14 bg-amber-50 rounded-md flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-lock text-accent text-xl"></i>
                </div>
                <h2 class="text-2xl font-bold text-slate-900">Confirm Password</h2>
                <p class="mt-2 text-sm text-slate-500">Please confirm your password before continuing.</p>
            </div>

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

            <form method="POST" action="{{ route('password.confirm') }}" class="space-y-4">
                @csrf

                <div>
                    <label for="password" class="block text-sm font-medium text-slate-700 mb-1">Password</label>
                    <input id="password" type="password" name="password" required autocomplete="current-password"
                        class="w-full px-3 py-2 border border-slate-200 rounded-md text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors">
                </div>

                <button type="submit"
                    class="w-full flex justify-center py-2.5 px-4 bg-primary text-white text-sm font-medium rounded-md hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-colors">
                    Confirm Password
                </button>

                @if (Route::has('password.request'))
                    <div class="text-center">
                        <a href="{{ route('password.request') }}" class="text-sm font-medium text-primary hover:text-primary-dark">
                            Forgot Your Password?
                        </a>
                    </div>
                @endif
            </form>
        </div>
    </div>
</div>
@endsection
