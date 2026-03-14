@extends('layouts.app')

@section('content')
<div class="bg-surface min-h-screen">
    <div class="container mx-auto px-4 max-w-7xl py-8">
        <div class="flex flex-col lg:flex-row gap-6">
            @include('partials.admin-sidebar')

            <!-- Main Content -->
            <div class="flex-1 min-w-0">
                <div class="mb-6">
                    <div class="flex items-center gap-3 mb-1">
                        <a href="{{ route('admin.locations.index') }}" class="text-slate-400 hover:text-slate-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                            </svg>
                        </a>
                        <h1 class="text-xl font-bold text-slate-900">Location Details</h1>
                    </div>
                </div>

                <div class="bg-white border border-slate-100 rounded-md shadow-sm p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-xs text-slate-500 uppercase tracking-wide mb-1">Name</label>
                            <p class="text-sm font-medium text-slate-900">{{ $location->name }}</p>
                        </div>
                        <div>
                            <label class="block text-xs text-slate-500 uppercase tracking-wide mb-1">District</label>
                            <p class="text-sm text-slate-900">{{ $location->district ?? '-' }}</p>
                        </div>
                        <div>
                            <label class="block text-xs text-slate-500 uppercase tracking-wide mb-1">Province</label>
                            <p class="text-sm text-slate-900">{{ $location->province ?? '-' }}</p>
                        </div>
                        <div>
                            <label class="block text-xs text-slate-500 uppercase tracking-wide mb-1">Latitude</label>
                            <p class="text-sm text-slate-900">{{ $location->latitude ?? '-' }}</p>
                        </div>
                        <div>
                            <label class="block text-xs text-slate-500 uppercase tracking-wide mb-1">Longitude</label>
                            <p class="text-sm text-slate-900">{{ $location->longitude ?? '-' }}</p>
                        </div>
                        <div>
                            <label class="block text-xs text-slate-500 uppercase tracking-wide mb-1">Status</label>
                            <span class="inline-flex items-center px-2 py-0.5 text-xs font-medium rounded-md
                                {{ $location->status == 'active' ? 'bg-emerald-50 text-emerald-700' : 'bg-red-50 text-red-700' }}">
                                {{ ucfirst($location->status) }}
                            </span>
                        </div>
                    </div>

                    <div class="mt-6 flex gap-3">
                        <a href="{{ route('admin.locations.edit', $location->id) }}" class="px-4 py-2 bg-primary hover:bg-primary-dark text-white text-sm font-medium rounded-md transition-colors">Edit Location</a>
                        <a href="{{ route('admin.locations.index') }}" class="px-4 py-2 border border-slate-200 rounded-md text-sm font-medium text-slate-700 hover:bg-slate-50 transition-colors">Back to Locations</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
