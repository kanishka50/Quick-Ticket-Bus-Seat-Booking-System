@extends('layouts.app')

@section('content')
<div class="bg-surface min-h-screen">
    <div class="container mx-auto px-4 py-8 max-w-2xl">
        <div class="mb-6 text-center">
            <h1 class="text-2xl font-bold text-slate-900">Provider Onboarding</h1>
            <p class="text-sm text-slate-500 mt-1">Complete your company profile to start offering transportation services</p>
        </div>

        <!-- Validation Errors -->
        @if ($errors->any())
            <div class="bg-red-50 border border-red-200 rounded-md p-4 mb-6">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-red-700">
                            @foreach ($errors->all() as $error)
                                {{ $error }}<br>
                            @endforeach
                        </p>
                    </div>
                </div>
            </div>
        @endif

        <div class="bg-white border border-slate-100 rounded-md shadow-sm p-6">
            <form method="POST" action="{{ route('provider.store') }}" enctype="multipart/form-data" class="space-y-5">
                @csrf

                <!-- Company Name -->
                <div>
                    <label for="company_name" class="block text-sm font-medium text-slate-700 mb-1">Company Name</label>
                    <input id="company_name" type="text" name="company_name" value="{{ old('company_name') }}" required
                        class="w-full px-3 py-2 border border-slate-200 rounded-md text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none">
                </div>

                <!-- Business Registration Number -->
                <div>
                    <label for="business_registration_number" class="block text-sm font-medium text-slate-700 mb-1">Business Registration Number</label>
                    <input id="business_registration_number" type="text" name="business_registration_number" value="{{ old('business_registration_number') }}" required
                        class="w-full px-3 py-2 border border-slate-200 rounded-md text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none">
                </div>

                <!-- Contact Number -->
                <div>
                    <label for="contact_number" class="block text-sm font-medium text-slate-700 mb-1">Contact Number</label>
                    <input id="contact_number" type="text" name="contact_number" value="{{ old('contact_number') }}" required
                        class="w-full px-3 py-2 border border-slate-200 rounded-md text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none">
                </div>

                <!-- Address -->
                <div>
                    <label for="address" class="block text-sm font-medium text-slate-700 mb-1">Business Address</label>
                    <textarea id="address" name="address" rows="2" required
                        class="w-full px-3 py-2 border border-slate-200 rounded-md text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none">{{ old('address') }}</textarea>
                </div>

                <!-- Company Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-slate-700 mb-1">Company Description</label>
                    <textarea id="description" name="description" rows="3"
                        class="w-full px-3 py-2 border border-slate-200 rounded-md text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none">{{ old('description') }}</textarea>
                    <p class="mt-1 text-xs text-slate-500">Describe your transportation services, company history, and any other relevant information.</p>
                </div>

                <!-- Company Logo -->
                <div>
                    <label for="company_logo" class="block text-sm font-medium text-slate-700 mb-1">Company Logo</label>
                    <div class="flex items-center">
                        <span class="inline-block h-12 w-12 rounded-md overflow-hidden bg-slate-100">
                            <svg class="h-full w-full text-slate-300" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </span>
                        <input type="file" id="company_logo" name="company_logo" accept="image/*"
                            class="ml-4 text-sm text-slate-600 file:mr-3 file:py-1.5 file:px-3 file:border file:border-slate-200 file:rounded-md file:text-sm file:font-medium file:bg-white file:text-slate-700 hover:file:bg-slate-50">
                    </div>
                    <p class="mt-1 text-xs text-slate-500">Upload your company logo (JPG, PNG, SVG).</p>
                </div>

                <!-- Terms and Conditions -->
                <div class="flex items-start">
                    <div class="flex items-center h-5">
                        <input id="terms" name="terms" type="checkbox" required
                            class="h-4 w-4 text-primary focus:ring-primary/20 border-slate-300 rounded">
                    </div>
                    <div class="ml-3 text-sm">
                        <label for="terms" class="font-medium text-slate-700">I agree to the terms and conditions</label>
                        <p class="text-slate-500">By registering as a provider, you agree to our <a href="{{ route('terms') }}" class="text-primary hover:text-primary-dark">Terms of Service</a> and <a href="{{ route('privacy') }}" class="text-primary hover:text-primary-dark">Privacy Policy</a>.</p>
                    </div>
                </div>

                <!-- Submit Button -->
                <div>
                    <button type="submit"
                        class="w-full py-2.5 px-4 bg-primary hover:bg-primary-dark text-white text-sm font-medium rounded-md transition-colors focus:ring-2 focus:ring-primary/20 focus:ring-offset-1">
                        Complete Registration
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
