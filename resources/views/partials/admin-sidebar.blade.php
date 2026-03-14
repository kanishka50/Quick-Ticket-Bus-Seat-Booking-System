<!-- Admin Dashboard Sidebar -->
<aside class="w-full lg:w-64 shrink-0">
    <div class="bg-white border border-slate-100 rounded-md shadow-sm overflow-hidden">
        <!-- Admin Info -->
        <div class="p-5 border-b border-slate-100 bg-slate-50">
            <div class="flex items-center space-x-3">
                <div class="w-11 h-11 bg-primary rounded-md flex items-center justify-center text-white overflow-hidden shrink-0">
                    @if(auth()->user()->profile_image)
                        <img src="{{ asset('storage/' . auth()->user()->profile_image) }}" alt="Profile" class="w-full h-full object-cover">
                    @else
                        <span class="text-base font-semibold">{{ substr(auth()->user()->name, 0, 1) }}</span>
                    @endif
                </div>
                <div class="min-w-0">
                    <p class="text-sm font-semibold text-slate-900 truncate">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-slate-500">Administrator</p>
                </div>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="p-2">
            <a href="{{ route('admin.dashboard') }}"
               class="flex items-center px-3 py-2.5 text-sm font-medium rounded-md transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-primary/10 text-primary' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5 mr-3 {{ request()->routeIs('admin.dashboard') ? 'text-primary' : 'text-slate-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                </svg>
                Dashboard
            </a>
            <a href="{{ route('admin.providers.index') }}"
               class="flex items-center px-3 py-2.5 text-sm font-medium rounded-md transition-colors {{ request()->routeIs('admin.providers.*') ? 'bg-primary/10 text-primary' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5 mr-3 {{ request()->routeIs('admin.providers.*') ? 'text-primary' : 'text-slate-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
                Providers
            </a>
            <a href="{{ route('admin.bookings.index') }}"
               class="flex items-center px-3 py-2.5 text-sm font-medium rounded-md transition-colors {{ request()->routeIs('admin.bookings.*') ? 'bg-primary/10 text-primary' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5 mr-3 {{ request()->routeIs('admin.bookings.*') ? 'text-primary' : 'text-slate-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                </svg>
                Bookings
            </a>
            <a href="{{ route('admin.routes.index') }}"
               class="flex items-center px-3 py-2.5 text-sm font-medium rounded-md transition-colors {{ request()->routeIs('admin.routes.*') ? 'bg-primary/10 text-primary' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5 mr-3 {{ request()->routeIs('admin.routes.*') ? 'text-primary' : 'text-slate-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                </svg>
                Routes
            </a>
            <a href="{{ route('admin.locations.index') }}"
               class="flex items-center px-3 py-2.5 text-sm font-medium rounded-md transition-colors {{ request()->routeIs('admin.locations.*') ? 'bg-primary/10 text-primary' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5 mr-3 {{ request()->routeIs('admin.locations.*') ? 'text-primary' : 'text-slate-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                Locations
            </a>
            <a href="{{ route('admin.notifications.index') }}"
               class="flex items-center px-3 py-2.5 text-sm font-medium rounded-md transition-colors {{ request()->routeIs('admin.notifications.*') ? 'bg-primary/10 text-primary' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5 mr-3 {{ request()->routeIs('admin.notifications.*') ? 'text-primary' : 'text-slate-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                </svg>
                Notifications
            </a>
            <a href="{{ route('profile.edit') }}"
               class="flex items-center px-3 py-2.5 text-sm font-medium rounded-md transition-colors {{ request()->routeIs('profile.*') ? 'bg-primary/10 text-primary' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5 mr-3 {{ request()->routeIs('profile.*') ? 'text-primary' : 'text-slate-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                My Profile
            </a>
        </nav>
    </div>
</aside>
