

<?php $__env->startSection('content'); ?>
<div class="bg-surface min-h-screen">
    <div class="container mx-auto px-4 max-w-7xl py-8">
        <div class="flex flex-col lg:flex-row gap-6">
            <?php echo $__env->make('partials.provider-sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

            <!-- Main Content -->
            <div class="flex-1 min-w-0">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h1 class="text-xl font-bold text-slate-900">Driver Management</h1>
                        <p class="text-sm text-slate-500 mt-1">Manage your drivers</p>
                    </div>
                    <a href="<?php echo e(route('provider.drivers.create')); ?>" class="inline-flex items-center px-4 py-2 bg-primary hover:bg-primary-dark text-white text-sm font-medium rounded-md transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                        </svg>
                        Add Driver
                    </a>
                </div>

                <?php if(session('success')): ?>
                    <div class="bg-emerald-50 border border-emerald-200 rounded-md p-4 mb-6">
                        <p class="text-sm text-emerald-700"><?php echo e(session('success')); ?></p>
                    </div>
                <?php endif; ?>

                <div class="bg-white border border-slate-100 rounded-md shadow-sm overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b border-slate-100 bg-slate-50">
                                    <th class="text-left text-xs font-medium text-slate-500 uppercase tracking-wide px-5 py-3">Name</th>
                                    <th class="text-left text-xs font-medium text-slate-500 uppercase tracking-wide px-5 py-3">Email</th>
                                    <th class="text-left text-xs font-medium text-slate-500 uppercase tracking-wide px-5 py-3">Phone</th>
                                    <th class="text-left text-xs font-medium text-slate-500 uppercase tracking-wide px-5 py-3">License #</th>
                                    <th class="text-left text-xs font-medium text-slate-500 uppercase tracking-wide px-5 py-3">Status</th>
                                    <th class="text-right text-xs font-medium text-slate-500 uppercase tracking-wide px-5 py-3">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50">
                                <?php $__empty_1 = true; $__currentLoopData = $drivers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $driver): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr class="hover:bg-slate-50/50">
                                    <td class="px-5 py-3 text-sm font-medium text-slate-900"><?php echo e($driver->user->name); ?></td>
                                    <td class="px-5 py-3 text-sm text-slate-600"><?php echo e($driver->user->email); ?></td>
                                    <td class="px-5 py-3 text-sm text-slate-600"><?php echo e($driver->phone ?? '-'); ?></td>
                                    <td class="px-5 py-3 text-sm text-slate-600"><?php echo e($driver->license_number); ?></td>
                                    <td class="px-5 py-3">
                                        <span class="inline-flex items-center px-2 py-0.5 text-xs font-medium rounded-md <?php echo e($driver->status == 'active' ? 'bg-emerald-50 text-emerald-700' : 'bg-red-50 text-red-700'); ?>">
                                            <?php echo e(ucfirst($driver->status)); ?>

                                        </span>
                                    </td>
                                    <td class="px-5 py-3 text-right">
                                        <a href="<?php echo e(route('provider.drivers.edit', $driver)); ?>" class="text-primary hover:text-primary-dark text-sm mr-3">Edit</a>
                                        <form action="<?php echo e(route('provider.drivers.destroy', $driver)); ?>" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this driver?')">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="text-red-500 hover:text-red-700 text-sm">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="6" class="px-5 py-12 text-center">
                                        <div class="w-12 h-12 bg-slate-100 rounded-md flex items-center justify-center mx-auto mb-3">
                                            <i class="fas fa-user-plus text-slate-400"></i>
                                        </div>
                                        <p class="text-sm text-slate-500">No drivers yet. Add your first driver.</p>
                                    </td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="px-5 py-4 border-t border-slate-100">
                        <?php echo e($drivers->links()); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH H:\bus-ticket-booking-system\resources\views/providers/drivers/index.blade.php ENDPATH**/ ?>