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
                        <h1 class="text-xl font-bold text-slate-900">Add New Location</h1>
                    </div>
                    <p class="text-sm text-slate-500 ml-8">Create a new bus stop location</p>
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
                    <form action="{{ route('admin.locations.store') }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label for="name" class="block text-sm font-medium text-slate-700 mb-1">Name</label>
                                <input type="text" name="name" id="name" value="{{ old('name') }}" required
                                    class="w-full px-3 py-2 border border-slate-200 rounded-md text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none">
                                @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label for="district" class="block text-sm font-medium text-slate-700 mb-1">District</label>
                                <input type="text" name="district" id="district" value="{{ old('district') }}"
                                    class="w-full px-3 py-2 border border-slate-200 rounded-md text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none">
                            </div>

                            <div>
                                <label for="province" class="block text-sm font-medium text-slate-700 mb-1">Province</label>
                                <input type="text" name="province" id="province" value="{{ old('province') }}"
                                    class="w-full px-3 py-2 border border-slate-200 rounded-md text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none">
                            </div>

                            <div>
                                <label for="latitude" class="block text-sm font-medium text-slate-700 mb-1">Latitude</label>
                                <input type="number" step="0.000001" name="latitude" id="latitude" value="{{ old('latitude') }}"
                                    class="w-full px-3 py-2 border border-slate-200 rounded-md text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none">
                            </div>

                            <div>
                                <label for="longitude" class="block text-sm font-medium text-slate-700 mb-1">Longitude</label>
                                <input type="number" step="0.000001" name="longitude" id="longitude" value="{{ old('longitude') }}"
                                    class="w-full px-3 py-2 border border-slate-200 rounded-md text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none">
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
                            <a href="{{ route('admin.locations.index') }}" class="px-4 py-2 border border-slate-200 rounded-md text-sm font-medium text-slate-700 hover:bg-slate-50 transition-colors">Cancel</a>
                            <button type="submit" class="px-6 py-2 bg-primary hover:bg-primary-dark text-white text-sm font-medium rounded-md transition-colors">Save Location</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
