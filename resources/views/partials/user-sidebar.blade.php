<!-- User Dashboard Sidebar -->
<aside class="w-full lg:w-64 shrink-0">
    <div class="bg-white border border-slate-100 rounded-md shadow-sm overflow-hidden">
        <!-- User Info -->
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
                    <p class="text-xs text-slate-500 truncate">{{ auth()->user()->email }}</p>
                </div>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="p-2">
            <a href="{{ route('user.dashboard') }}"
               class="flex items-center px-3 py-2.5 text-sm font-medium rounded-md transition-colors {{ request()->routeIs('user.dashboard') ? 'bg-primary/10 text-primary' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5 mr-3 {{ request()->routeIs('user.dashboard') ? 'text-primary' : 'text-slate-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                </svg>
                Dashboard
            </a>
            <a href="{{ route('bookings.index') }}"
               class="flex items-center px-3 py-2.5 text-sm font-medium rounded-md transition-colors {{ request()->routeIs('bookings.index') || request()->routeIs('bookings.show') ? 'bg-primary/10 text-primary' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5 mr-3 {{ request()->routeIs('bookings.index') || request()->routeIs('bookings.show') ? 'text-primary' : 'text-slate-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                </svg>
                My Bookings
            </a>
            <a href="{{ route('user.notifications') }}"
               class="flex items-center px-3 py-2.5 text-sm font-medium rounded-md transition-colors {{ request()->routeIs('user.notifications') ? 'bg-primary/10 text-primary' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5 mr-3 {{ request()->routeIs('user.notifications') ? 'text-primary' : 'text-slate-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                </svg>
                Notifications
            </a>
            <a href="{{ route('profile.edit') }}"
               class="flex items-center px-3 py-2.5 text-sm font-medium rounded-md transition-colors {{ request()->routeIs('profile.edit') ? 'bg-primary/10 text-primary' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5 mr-3 {{ request()->routeIs('profile.edit') ? 'text-primary' : 'text-slate-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                Edit Profile
            </a>
        </nav>
    </div>
</aside>
