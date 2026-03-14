<!-- Provider Dashboard Sidebar -->
<aside class="w-full lg:w-64 shrink-0">
    <div class="bg-white border border-slate-100 rounded-md shadow-sm overflow-hidden">
        <!-- Provider Info -->
        <div class="p-5 border-b border-slate-100 bg-slate-50">
            <div class="flex items-center space-x-3">
                <div class="w-11 h-11 bg-primary rounded-md flex items-center justify-center text-white overflow-hidden shrink-0">
                    <?php if(auth()->user()->profile_image): ?>
                        <img src="<?php echo e(asset('storage/' . auth()->user()->profile_image)); ?>" alt="Profile" class="w-full h-full object-cover">
                    <?php else: ?>
                        <span class="text-base font-semibold"><?php echo e(substr(auth()->user()->name, 0, 1)); ?></span>
                    <?php endif; ?>
                </div>
                <div class="min-w-0">
                    <p class="text-sm font-semibold text-slate-900 truncate"><?php echo e(auth()->user()->name); ?></p>
                    <p class="text-xs text-slate-500 truncate"><?php echo e(auth()->user()->provider->company_name); ?></p>
                </div>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="p-2">
            <a href="<?php echo e(route('provider.dashboard')); ?>"
               class="flex items-center px-3 py-2.5 text-sm font-medium rounded-md transition-colors <?php echo e(request()->routeIs('provider.dashboard') ? 'bg-primary/10 text-primary' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900'); ?>">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5 mr-3 <?php echo e(request()->routeIs('provider.dashboard') ? 'text-primary' : 'text-slate-400'); ?>" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                </svg>
                Dashboard
            </a>
            <a href="<?php echo e(route('provider.buses.index')); ?>"
               class="flex items-center px-3 py-2.5 text-sm font-medium rounded-md transition-colors <?php echo e(request()->routeIs('provider.buses.*') ? 'bg-primary/10 text-primary' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900'); ?>">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5 mr-3 <?php echo e(request()->routeIs('provider.buses.*') ? 'text-primary' : 'text-slate-400'); ?>" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                </svg>
                Buses
            </a>
            <a href="<?php echo e(route('provider.schedules.index')); ?>"
               class="flex items-center px-3 py-2.5 text-sm font-medium rounded-md transition-colors <?php echo e(request()->routeIs('provider.schedules.*') ? 'bg-primary/10 text-primary' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900'); ?>">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5 mr-3 <?php echo e(request()->routeIs('provider.schedules.*') ? 'text-primary' : 'text-slate-400'); ?>" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                Schedules
            </a>
            <a href="<?php echo e(route('provider.schedules.dates')); ?>"
               class="flex items-center px-3 py-2.5 text-sm font-medium rounded-md transition-colors <?php echo e(request()->routeIs('provider.schedules.dates*') ? 'bg-primary/10 text-primary' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900'); ?>">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5 mr-3 <?php echo e(request()->routeIs('provider.schedules.dates*') ? 'text-primary' : 'text-slate-400'); ?>" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Schedule Dates
            </a>
            <a href="<?php echo e(route('provider.drivers.index')); ?>"
               class="flex items-center px-3 py-2.5 text-sm font-medium rounded-md transition-colors <?php echo e(request()->routeIs('provider.drivers.*') ? 'bg-primary/10 text-primary' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900'); ?>">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5 mr-3 <?php echo e(request()->routeIs('provider.drivers.*') ? 'text-primary' : 'text-slate-400'); ?>" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                Drivers
            </a>
            <a href="<?php echo e(route('provider.assignments.index')); ?>"
               class="flex items-center px-3 py-2.5 text-sm font-medium rounded-md transition-colors <?php echo e(request()->routeIs('provider.assignments.*') ? 'bg-primary/10 text-primary' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900'); ?>">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5 mr-3 <?php echo e(request()->routeIs('provider.assignments.*') ? 'text-primary' : 'text-slate-400'); ?>" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                </svg>
                Assignments
            </a>
            <a href="<?php echo e(route('provider.bookings.index')); ?>"
               class="flex items-center px-3 py-2.5 text-sm font-medium rounded-md transition-colors <?php echo e(request()->routeIs('provider.bookings.*') ? 'bg-primary/10 text-primary' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900'); ?>">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5 mr-3 <?php echo e(request()->routeIs('provider.bookings.*') ? 'text-primary' : 'text-slate-400'); ?>" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                </svg>
                Bookings
            </a>
            <a href="<?php echo e(route('provider.notifications.index')); ?>"
               class="flex items-center px-3 py-2.5 text-sm font-medium rounded-md transition-colors <?php echo e(request()->routeIs('provider.notifications.*') ? 'bg-primary/10 text-primary' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900'); ?>">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5 mr-3 <?php echo e(request()->routeIs('provider.notifications.*') ? 'text-primary' : 'text-slate-400'); ?>" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                </svg>
                Notifications
            </a>
            <a href="<?php echo e(route('provider.edit')); ?>"
               class="flex items-center px-3 py-2.5 text-sm font-medium rounded-md transition-colors <?php echo e(request()->routeIs('provider.edit') ? 'bg-primary/10 text-primary' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900'); ?>">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5 mr-3 <?php echo e(request()->routeIs('provider.edit') ? 'text-primary' : 'text-slate-400'); ?>" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
                Company Profile
            </a>
            <a href="<?php echo e(route('profile.edit')); ?>"
               class="flex items-center px-3 py-2.5 text-sm font-medium rounded-md transition-colors <?php echo e(request()->routeIs('profile.*') ? 'bg-primary/10 text-primary' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900'); ?>">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5 mr-3 <?php echo e(request()->routeIs('profile.*') ? 'text-primary' : 'text-slate-400'); ?>" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                My Profile
            </a>
        </nav>
    </div>
</aside>
<?php /**PATH H:\bus-ticket-booking-system\resources\views/partials/provider-sidebar.blade.php ENDPATH**/ ?>