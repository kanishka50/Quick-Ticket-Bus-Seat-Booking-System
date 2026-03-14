@extends('layouts.app')

@section('content')
<div class="bg-surface min-h-screen">
    <div class="container mx-auto px-4 max-w-7xl py-8">
        <div class="flex flex-col lg:flex-row gap-6">
            @include('partials.admin-sidebar')

            <!-- Main Content -->
            <div class="flex-1 min-w-0">
                <div class="mb-6">
                    <h1 class="text-xl font-bold text-slate-900">Provider Management</h1>
                    <p class="text-sm text-slate-500 mt-1">Manage bus service providers</p>
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
                    <!-- Status Filter Tabs -->
                    <div class="border-b border-slate-100">
                        <nav class="flex -mb-px px-5 space-x-6 overflow-x-auto" aria-label="Tabs">
                            @php
                                $tabs = [
                                    'all' => 'All',
                                    'active' => 'Active',
                                    'pending' => 'Pending',
                                    'inactive' => 'Inactive',
                                    'suspended' => 'Suspended',
                                ];
                            @endphp
                            @foreach($tabs as $key => $label)
                                <a href="{{ route('admin.providers.index', ['status' => $key]) }}"
                                   class="whitespace-nowrap py-3 px-1 border-b-2 text-sm font-medium transition-colors
                                       {{ $status === $key
                                           ? 'border-primary text-primary'
                                           : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300' }}">
                                    {{ $label }}
                                </a>
                            @endforeach
                        </nav>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b border-slate-100 bg-slate-50">
                                    <th class="text-left text-xs font-medium text-slate-500 uppercase tracking-wide px-5 py-3">Company</th>
                                    <th class="text-left text-xs font-medium text-slate-500 uppercase tracking-wide px-5 py-3">Contact</th>
                                    <th class="text-left text-xs font-medium text-slate-500 uppercase tracking-wide px-5 py-3">Status</th>
                                    <th class="text-left text-xs font-medium text-slate-500 uppercase tracking-wide px-5 py-3">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50">
                                @forelse($providers as $provider)
                                <tr class="hover:bg-slate-50/50">
                                    <td class="px-5 py-3">
                                        <span class="text-sm font-medium text-slate-900">{{ $provider->company_name }}</span>
                                        <span class="block text-xs text-slate-500">{{ $provider->business_registration_number }}</span>
                                    </td>
                                    <td class="px-5 py-3">
                                        <span class="text-sm text-slate-900">{{ $provider->contact_number }}</span>
                                        <span class="block text-xs text-slate-500">{{ $provider->user->email }}</span>
                                    </td>
                                    <td class="px-5 py-3">
                                        <span class="inline-flex items-center px-2 py-0.5 text-xs font-medium rounded-md
                                            @if($provider->status == 'active') bg-emerald-50 text-emerald-700
                                            @elseif($provider->status == 'pending') bg-amber-50 text-amber-700
                                            @elseif($provider->status == 'inactive') bg-red-50 text-red-700
                                            @else bg-slate-100 text-slate-700
                                            @endif">
                                            {{ ucfirst($provider->status) }}
                                        </span>
                                    </td>
                                    <td class="px-5 py-3">
                                        <button type="button"
                                                onclick="openStatusModal('{{ $provider->id }}', '{{ $provider->company_name }}', '{{ $provider->status }}')"
                                                class="text-primary hover:text-primary-dark text-sm font-medium">
                                            Update Status
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="px-5 py-12 text-center">
                                        <div class="w-12 h-12 bg-slate-100 rounded-md flex items-center justify-center mx-auto mb-3">
                                            <i class="fas fa-building text-slate-400"></i>
                                        </div>
                                        <h3 class="text-sm font-medium text-slate-900 mb-1">No providers found</h3>
                                        <p class="text-xs text-slate-500">
                                            @if($status !== 'all')
                                                No {{ $status }} providers. <a href="{{ route('admin.providers.index') }}" class="text-primary hover:text-primary-dark">View all providers</a>
                                            @else
                                                No providers registered yet.
                                            @endif
                                        </p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="px-5 py-4 border-t border-slate-100">
                        {{ $providers->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Status Update Modal -->
<div id="statusModal" class="fixed inset-0 bg-slate-900/50 hidden overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto max-w-md">
        <div class="bg-white rounded-md shadow-lg border border-slate-200">
            <div class="px-5 py-4 border-b border-slate-100">
                <h3 class="text-sm font-semibold text-slate-900" id="modalTitle">Update Provider Status</h3>
            </div>
            <div class="p-5">
                <form id="statusForm" action="" method="POST">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" id="providerId" name="provider_id" value="">

                    <div class="mb-4">
                        <label for="statusSelect" class="block text-sm font-medium text-slate-700 mb-1">Status</label>
                        <select id="statusSelect" name="status"
                            class="w-full px-3 py-2 border border-slate-200 rounded-md text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none bg-white">
                            <option value="active">Active</option>
                            <option value="pending">Pending</option>
                            <option value="inactive">Inactive</option>
                            <option value="suspended">Suspended</option>
                        </select>
                    </div>

                    <div id="reasonContainer" class="mb-4 hidden">
                        <label for="reason" class="block text-sm font-medium text-slate-700 mb-1">Reason</label>
                        <textarea name="reason" id="reason" rows="3"
                            class="w-full px-3 py-2 border border-slate-200 rounded-md text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none"></textarea>
                        <p class="mt-1 text-xs text-slate-400">Required for Inactive or Suspended status</p>
                    </div>

                    <div class="flex justify-end gap-3 mt-5">
                        <button type="button" onclick="closeStatusModal()"
                            class="px-4 py-2 border border-slate-200 rounded-md text-sm font-medium text-slate-700 hover:bg-slate-50 transition-colors">
                            Cancel
                        </button>
                        <button type="submit"
                            class="px-4 py-2 bg-primary hover:bg-primary-dark text-white text-sm font-medium rounded-md transition-colors">
                            Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function openStatusModal(id, name, currentStatus) {
        document.getElementById('modalTitle').textContent = 'Update Status: ' + name;
        document.getElementById('providerId').value = id;
        document.getElementById('statusForm').action = "/admin/providers/" + id + "/status";
        const statusSelect = document.getElementById('statusSelect');
        statusSelect.value = currentStatus;
        toggleReasonField(currentStatus);
        document.getElementById('statusModal').classList.remove('hidden');
    }

    function closeStatusModal() {
        document.getElementById('statusModal').classList.add('hidden');
    }

    document.getElementById('statusSelect').addEventListener('change', function() {
        toggleReasonField(this.value);
    });

    function toggleReasonField(status) {
        const reasonContainer = document.getElementById('reasonContainer');
        if (status === 'inactive' || status === 'suspended') {
            reasonContainer.classList.remove('hidden');
        } else {
            reasonContainer.classList.add('hidden');
        }
    }
</script>
@endsection
