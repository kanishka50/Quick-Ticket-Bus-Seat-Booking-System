<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title>Driver Dashboard - <?php echo e(config('app.name')); ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-100 min-h-screen">
    <nav class="bg-blue-700 text-white shadow-lg">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <a href="<?php echo e(route('driver.dashboard')); ?>" class="text-xl font-bold">Driver Panel</a>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-sm"><?php echo e(Auth::user()->name); ?></span>
                    <form action="<?php echo e(route('logout')); ?>" method="POST" class="inline">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="text-sm bg-blue-800 hover:bg-blue-900 px-3 py-1 rounded">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <?php if(session('success')): ?>
    <div class="container mx-auto px-4 mt-4">
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)">
            <?php echo e(session('success')); ?>

        </div>
    </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
    <div class="container mx-auto px-4 mt-4">
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)">
            <?php echo e(session('error')); ?>

        </div>
    </div>
    <?php endif; ?>

    <main class="container mx-auto px-4 py-6">
        <?php echo $__env->yieldContent('content'); ?>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.12.0/dist/cdn.min.js" defer></script>
</body>
</html>
<?php /**PATH H:\bus-ticket-booking-system\resources\views/layouts/driver.blade.php ENDPATH**/ ?>