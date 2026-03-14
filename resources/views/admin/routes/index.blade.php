@extends('layouts.app')

@section('content')
<div class="bg-surface min-h-screen">
    <div class="container mx-auto px-4 max-w-7xl py-8">
        <div class="flex flex-col lg:flex-row gap-6">
            @include('partials.admin-sidebar')

            <!-- Main Content -->
            <div class="flex-1 min-w-0">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h1 class="text-xl font-bold text-slate-900">Route Management</h1>
                        <p class="text-sm text-slate-500 mt-1">Manage bus routes</p>
                    </div>
                    <a href="{{ route('admin.routes.create') }}" class="inline-flex items-center px-4 py-2 bg-primary hover:bg-primary-dark text-white text-sm font-medium rounded-md transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                        </svg>
                        Add Route
                    </a>
                </div>

                @if(session('success'))
                    <div class="bg-emerald-50 border border-emerald-200 rounded-md p-4 mb-6">
                        <p class="text-sm text-emerald-700">{{ session('success') }}</p>
                    </div>
                @endif

                <div class="bg-white border border-slate-100 rounded-md shadow-sm overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b border-slate-100 bg-slate-50">
                                    <th class="text-left text-xs font-medium text-slate-500 uppercase tracking-wide px-5 py-3">Origin</th>
                                    <th class="text-left text-xs font-medium text-slate-500 uppercase tracking-wide px-5 py-3">Destination</th>
                                    <th class="text-left text-xs font-medium text-slate-500 uppercase tracking-wide px-5 py-3">Distance</th>
                                    <th class="text-left text-xs font-medium text-slate-500 uppercase tracking-wide px-5 py-3">Duration</th>
                                    <th class="text-left text-xs font-medium text-slate-500 uppercase tracking-wide px-5 py-3">Status</th>
                                    <th class="text-left text-xs font-medium text-slate-500 uppercase tracking-wide px-5 py-3">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50">
                                @forelse($routes as $route)
                                <tr class="hover:bg-slate-50/50">
                                    <td class="px-5 py-3 text-sm font-medium text-slate-900">{{ $route->origin->name }}</td>
                                    <td class="px-5 py-3 text-sm font-medium text-slate-900">{{ $route->destination->name }}</td>
                                    <td class="px-5 py-3 text-sm text-slate-600">{{ $route->distance }} km</td>
                                    <td class="px-5 py-3 text-sm text-slate-600">{{ $route->estimated_duration }} min</td>
                                    <td class="px-5 py-3">
                                        <span class="inline-flex items-center px-2 py-0.5 text-xs font-medium rounded-md
                                            {{ $route->status == 'active' ? 'bg-emerald-50 text-emerald-700' : 'bg-red-50 text-red-700' }}">
                                            {{ ucfirst($route->status) }}
                                        </span>
                                    </td>
                                    <td class="px-5 py-3">
                                        <a href="{{ route('admin.routes.show', $route->id) }}" class="text-primary hover:text-primary-dark text-sm font-medium">View</a>
                                        <a href="{{ route('admin.routes.edit', $route->id) }}" class="ml-3 text-slate-600 hover:text-slate-900 text-sm font-medium">Edit</a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="px-5 py-12 text-center">
                                        <div class="w-12 h-12 bg-slate-100 rounded-md flex items-center justify-center mx-auto mb-3">
                                            <i class="fas fa-route text-slate-400"></i>
                                        </div>
                                        <h3 class="text-sm font-medium text-slate-900 mb-1">No routes found</h3>
                                        <p class="text-xs text-slate-500">Get started by adding a new route.</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="px-5 py-4 border-t border-slate-100">
                        {{ $routes->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
