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
                        <a href="{{ route('admin.routes.index') }}" class="text-slate-400 hover:text-slate-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                            </svg>
                        </a>
                        <h1 class="text-xl font-bold text-slate-900">Add New Route</h1>
                    </div>
                    <p class="text-sm text-slate-500 ml-8">Create a new bus route</p>
                </div>

                @if ($errors->any())
                    <div class="bg-red-50 border border-red-200 rounded-md p-4 mb-6">
                        <p class="text-sm text-red-700">
                            @foreach ($errors->all() as $error)
                                {{ $error }}<br>
                            @endforeach
                        </p>
                    </div>
                @endif

                <div class="bg-white border border-slate-100 rounded-md shadow-sm p-6">
                    <form action="{{ route('admin.routes.store') }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label for="origin_id" class="block text-sm font-medium text-slate-700 mb-1">Origin</label>
                                <select name="origin_id" id="origin_id" required
                                    class="w-full px-3 py-2 border border-slate-200 rounded-md text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none bg-white">
                                    <option value="">Select Origin</option>
                                    @foreach($locations as $location)
                                    <option value="{{ $location->id }}" {{ old('origin_id') == $location->id ? 'selected' : '' }}>{{ $location->name }}</option>
                                    @endforeach
                                </select>
                                @error('origin_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="destination_id" class="block text-sm font-medium text-slate-700 mb-1">Destination</label>
                                <select name="destination_id" id="destination_id" required
                                    class="w-full px-3 py-2 border border-slate-200 rounded-md text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none bg-white">
                                    <option value="">Select Destination</option>
                                    @foreach($locations as $location)
                                    <option value="{{ $location->id }}" {{ old('destination_id') == $location->id ? 'selected' : '' }}>{{ $location->name }}</option>
                                    @endforeach
                                </select>
                                @error('destination_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="distance" class="block text-sm font-medium text-slate-700 mb-1">Distance (km)</label>
                                <input type="number" name="distance" id="distance" value="{{ old('distance') }}" required
                                    class="w-full px-3 py-2 border border-slate-200 rounded-md text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none">
                                @error('distance') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="estimated_duration" class="block text-sm font-medium text-slate-700 mb-1">Estimated Duration (min)</label>
                                <input type="number" name="estimated_duration" id="estimated_duration" value="{{ old('estimated_duration') }}" required
                                    class="w-full px-3 py-2 border border-slate-200 rounded-md text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none">
                                @error('estimated_duration') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="status" class="block text-sm font-medium text-slate-700 mb-1">Status</label>
                                <select name="status" id="status" required
                                    class="w-full px-3 py-2 border border-slate-200 rounded-md text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none bg-white">
                                    <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end gap-3">
                            <a href="{{ route('admin.routes.index') }}" class="px-4 py-2 border border-slate-200 rounded-md text-sm font-medium text-slate-700 hover:bg-slate-50 transition-colors">Cancel</a>
                            <button type="submit" class="px-6 py-2 bg-primary hover:bg-primary-dark text-white text-sm font-medium rounded-md transition-colors">Save Route</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
