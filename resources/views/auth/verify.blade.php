@extends('layouts.app')

@section('content')
<div class="bg-surface min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full">
        <div class="bg-white border border-slate-100 rounded-md shadow-sm p-8">
            <div class="text-center mb-6">
                <div class="w-14 h-14 bg-primary/10 rounded-md flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-envelope text-primary text-xl"></i>
                </div>
                <h2 class="text-2xl font-bold text-slate-900">Verify Your Email</h2>
                <p class="mt-2 text-sm text-slate-500">Before proceeding, please check your email for a verification link.</p>
            </div>

            @if (session('resent'))
                <div class="bg-emerald-50 border border-emerald-200 rounded-md p-3 mb-4">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle text-emerald-500 mr-2 text-sm"></i>
                        <p class="text-sm text-emerald-700">A fresh verification link has been sent to your email address.</p>
                    </div>
                </div>
            @endif

            <p class="text-sm text-slate-600 mb-4">
                If you did not receive the email, click the button below to request another.
            </p>

            <form method="POST" action="{{ route('verification.resend') }}">
                @csrf
                <button type="submit"
                    class="w-full flex justify-center py-2.5 px-4 bg-primary text-white text-sm font-medium rounded-md hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-colors">
                    <i class="fas fa-paper-plane mr-2"></i> Resend Verification Email
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
