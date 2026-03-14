@extends('layouts.app')

@section('content')
<div class="bg-surface min-h-screen">
    <div class="container mx-auto px-4 py-12 max-w-md">
        <div class="bg-white border border-slate-100 rounded-md shadow-sm p-8 text-center">
            <div class="mx-auto flex items-center justify-center h-14 w-14 rounded-md bg-amber-50 mb-5">
                <svg class="h-7 w-7 text-amber-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>

            <h2 class="text-xl font-bold text-slate-900 mb-2">Account Pending Approval</h2>

            <p class="text-sm text-slate-600 mb-6">
                Thank you for registering <strong>{{ $provider->company_name }}</strong>. Your provider account is currently under review by our admin team.
            </p>

            <div class="bg-amber-50 border border-amber-200 rounded-md p-4 mb-6 text-left">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-amber-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-amber-700">
                            You will be able to access your provider dashboard once your account has been approved. This usually takes 1-2 business days.
                        </p>
                    </div>
                </div>
            </div>

            <div class="text-sm text-slate-500 mb-6">
                <p>Status: <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-medium bg-amber-50 text-amber-700">{{ ucfirst($provider->status) }}</span></p>
            </div>

            <a href="{{ route('home') }}" class="w-full inline-flex justify-center py-2.5 px-4 bg-primary hover:bg-primary-dark text-white text-sm font-medium rounded-md transition-colors">
                Go to Home Page
            </a>
        </div>
    </div>
</div>
@endsection
