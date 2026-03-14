<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bus Ticket Management - Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    <style>
        [x-cloak] { display: none !important; }
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.12.0/cdn.min.js" defer></script>
</head>
<body class="bg-gray-100">
    <div x-data="{ sidebarOpen: false }">
        <!-- Sidebar -->
        <div :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed top-0 left-0 z-30 w-64 h-screen bg-gray-800 transition-transform duration-300 ease-in-out md:translate-x-0">
            <div class="flex items-center justify-center h-16 bg-gray-900">
                <h2 class="text-xl font-bold text-white">BusTicket Admin</h2>
            </div>
            <nav class="mt-5">
    <a href="<?php echo e(route('admin.dashboard')); ?>" class="flex items-center px-6 py-3 text-white hover:bg-gray-700 <?php echo e(request()->routeIs('admin.dashboard') ? 'bg-gray-700' : ''); ?>">
        <i class="fas fa-tachometer-alt mr-3"></i>
        <span>Dashboard</span>
    </a>
    <a href="<?php echo e(route('admin.providers.index')); ?>" class="flex items-center px-6 py-3 text-white hover:bg-gray-700 <?php echo e(request()->routeIs('admin.providers*') ? 'bg-gray-700' : ''); ?>">
        <i class="fas fa-bus mr-3"></i>
        <span>Providers</span>
    </a>
    <a href="<?php echo e(route('admin.routes.index')); ?>" class="flex items-center px-6 py-3 text-white hover:bg-gray-700 <?php echo e(request()->routeIs('admin.routes*') ? 'bg-gray-700' : ''); ?>">
        <i class="fas fa-route mr-3"></i>
        <span>Routes</span>
    </a>
    <a href="<?php echo e(route('admin.locations.index')); ?>" class="flex items-center px-6 py-3 text-white hover:bg-gray-700 <?php echo e(request()->routeIs('admin.locations*') ? 'bg-gray-700' : ''); ?>">
        <i class="fas fa-map-marker-alt mr-3"></i>
        <span>Locations</span>
    </a>
</nav>
        </div>

        <!-- Content -->
        <div class="md:ml-64 min-h-screen">
            <!-- Top navigation -->
            <div class="bg-white shadow-sm">
                <div class="flex items-center justify-between h-16 px-4">
                    <button @click="sidebarOpen = !sidebarOpen" class="md:hidden text-gray-500 focus:outline-none">
                        <i class="fas fa-bars"></i>
                    </button>
                    <div class="flex items-center">
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center text-gray-500 focus:outline-none">
                                <img src="https://ui-avatars.com/api/?name=<?php echo e(Auth::user()->name); ?>" class="h-8 w-8 rounded-full mr-2">
                                <span class="text-sm"><?php echo e(Auth::user()->name); ?></span>
                                <i class="fas fa-chevron-down ml-2"></i>
                            </button>
                            <div x-show="open" x-cloak @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white py-2 rounded-lg shadow-xl">
                                <a href="" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
                                <form method="POST" action="<?php echo e(route('logout')); ?>">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Logout</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Flash messages -->
            <?php if(session('success')): ?>
            <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 4000)" x-show="show" class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 mx-4 mt-4">
                <div class="flex">
                    <div class="py-1"><i class="fas fa-check-circle"></i></div>
                    <div class="ml-3">
                        <p class="text-sm"><?php echo e(session('success')); ?></p>
                    </div>
                    <div class="ml-auto">
                        <button @click="show = false" class="text-green-700">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <?php if(session('error')): ?>
            <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 4000)" x-show="show" class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 mx-4 mt-4">
                <div class="flex">
                    <div class="py-1"><i class="fas fa-exclamation-circle"></i></div>
                    <div class="ml-3">
                        <p class="text-sm"><?php echo e(session('error')); ?></p>
                    </div>
                    <div class="ml-auto">
                        <button @click="show = false" class="text-red-700">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <!-- Page content -->
            <div class="p-4">
                <?php echo $__env->yieldContent('content'); ?>
            </div>
        </div>
    </div>
</body>
</html><?php /**PATH H:\bus-ticket-booking-system\resources\views/layouts/admin.blade.php ENDPATH**/ ?>