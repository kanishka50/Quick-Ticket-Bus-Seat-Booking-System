@extends('layouts.app')

@section('content')
<div class="bg-surface min-h-screen">
    <div class="container mx-auto px-4 max-w-7xl py-8">
        <div class="flex flex-col lg:flex-row gap-6">
            @include('partials.provider-sidebar')

            <!-- Main Content -->
            <div class="flex-1 min-w-0">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h1 class="text-xl font-bold text-slate-900">Manage Buses</h1>
                        <p class="text-sm text-slate-500 mt-1">View and manage your bus fleet</p>
                    </div>
                    <a href="{{ route('provider.buses.create') }}" class="inline-flex items-center px-4 py-2 bg-primary hover:bg-primary-dark text-white text-sm font-medium rounded-md transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                        </svg>
                        Add New Bus
                    </a>
                </div>

                @if(session('success'))
                    <div class="bg-emerald-50 border border-emerald-200 rounded-md p-4 mb-6">
                        <p class="text-sm text-emerald-700">{{ session('success') }}</p>
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-red-50 border border-red-200 rounded-md p-4 mb-6">
                        <p class="text-sm text-red-700">{{ session('error') }}</p>
                    </div>
                @endif

                <div class="bg-white border border-slate-100 rounded-md shadow-sm overflow-hidden">
                    @if($buses->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b border-slate-100 bg-slate-50">
                                    <th class="text-left text-xs font-medium text-slate-500 uppercase tracking-wide px-5 py-3">Registration</th>
                                    <th class="text-left text-xs font-medium text-slate-500 uppercase tracking-wide px-5 py-3">Name</th>
                                    <th class="text-left text-xs font-medium text-slate-500 uppercase tracking-wide px-5 py-3">Type</th>
                                    <th class="text-left text-xs font-medium text-slate-500 uppercase tracking-wide px-5 py-3">Seats</th>
                                    <th class="text-left text-xs font-medium text-slate-500 uppercase tracking-wide px-5 py-3">Status</th>
                                    <th class="text-left text-xs font-medium text-slate-500 uppercase tracking-wide px-5 py-3">Amenities</th>
                                    <th class="text-right text-xs font-medium text-slate-500 uppercase tracking-wide px-5 py-3">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50">
                                @foreach($buses as $bus)
                                <tr class="hover:bg-slate-50/50">
                                    <td class="px-5 py-3">
                                        <span class="text-sm font-medium text-slate-900">{{ $bus->registration_number }}</span>
                                    </td>
                                    <td class="px-5 py-3">
                                        <span class="text-sm text-slate-600">{{ $bus->name ?? 'N/A' }}</span>
                                    </td>
                                    <td class="px-5 py-3">
                                        <span class="text-sm text-slate-600">{{ $bus->busType->name }}</span>
                                    </td>
                                    <td class="px-5 py-3">
                                        <span class="text-sm text-slate-600">{{ $bus->total_seats }}</span>
                                    </td>
                                    <td class="px-5 py-3">
                                        <span class="inline-flex items-center px-2 py-0.5 text-xs font-medium rounded-md
                                            @if($bus->status == 'active') bg-emerald-50 text-emerald-700
                                            @elseif($bus->status == 'inactive') bg-slate-100 text-slate-600
                                            @else bg-amber-50 text-amber-700 @endif">
                                            {{ ucfirst($bus->status) }}
                                        </span>
                                    </td>
                                    <td class="px-5 py-3">
                                        <div class="flex flex-wrap gap-1">
                                            @php $amenities = json_decode($bus->amenities) ?? []; @endphp
                                            @foreach($amenities as $amenity)
                                                <span class="px-1.5 py-0.5 text-xs rounded bg-primary/5 text-primary">{{ $amenity }}</span>
                                            @endforeach
                                            @if(count($amenities) == 0)
                                                <span class="text-xs text-slate-400">None</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-5 py-3 text-right">
                                        <div class="flex justify-end space-x-2">
                                            <a href="{{ route('provider.buses.edit', $bus) }}" class="text-primary hover:text-primary-dark" title="Edit">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5" viewBox="0 0 20 20" fill="currentColor">
                                                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                                </svg>
                                            </a>
                                            <button onclick="confirmDelete({{ $bus->id }})" class="text-red-500 hover:text-red-700" title="Delete">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="px-5 py-4 border-t border-slate-100">
                        {{ $buses->links() }}
                    </div>
                    @else
                    <div class="text-center py-12">
                        <div class="w-12 h-12 bg-slate-100 rounded-md flex items-center justify-center mx-auto mb-3">
                            <i class="fas fa-bus text-slate-400"></i>
                        </div>
                        <h3 class="text-sm font-medium text-slate-900 mb-1">No buses found</h3>
                        <p class="text-xs text-slate-500 mb-4">Get started by adding a new bus.</p>
                        <a href="{{ route('provider.buses.create') }}" class="inline-flex items-center px-4 py-2 bg-primary hover:bg-primary-dark text-white text-sm font-medium rounded-md transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="-ml-1 mr-2 h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                            </svg>
                            Add New Bus
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed z-50 inset-0 overflow-y-auto hidden">
    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="fixed inset-0 bg-slate-900/50 transition-opacity" onclick="closeDeleteModal()"></div>
        <div class="relative bg-white rounded-md shadow-lg max-w-sm w-full p-6">
            <div class="flex items-start">
                <div class="flex-shrink-0 w-10 h-10 bg-red-50 rounded-md flex items-center justify-center">
                    <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-semibold text-slate-900">Delete Bus</h3>
                    <p class="text-xs text-slate-500 mt-1">Are you sure you want to delete this bus? This action cannot be undone.</p>
                </div>
            </div>
            <div class="flex justify-end gap-3 mt-5">
                <button type="button" onclick="closeDeleteModal()" class="px-4 py-2 border border-slate-200 rounded-md text-sm font-medium text-slate-700 hover:bg-slate-50 transition-colors">
                    Cancel
                </button>
                <form id="deleteForm" method="POST" action="">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-md transition-colors">
                        Delete
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function confirmDelete(busId) {
        const deleteForm = document.getElementById('deleteForm');
        deleteForm.action = `/provider/buses/${busId}`;
        document.getElementById('deleteModal').classList.remove('hidden');
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
    }
</script>
@endsection
