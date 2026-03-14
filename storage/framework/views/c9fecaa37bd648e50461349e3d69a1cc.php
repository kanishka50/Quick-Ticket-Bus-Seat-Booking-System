

<?php $__env->startSection('content'); ?>
<div class="bg-surface min-h-screen">
    <div class="container mx-auto px-4 max-w-7xl py-8">
        <div class="flex flex-col lg:flex-row gap-6">
            <?php echo $__env->make('partials.admin-sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

            <!-- Main Content -->
            <div class="flex-1 min-w-0">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h1 class="text-xl font-bold text-slate-900">Location Management</h1>
                        <p class="text-sm text-slate-500 mt-1">Manage bus stop locations</p>
                    </div>
                    <a href="<?php echo e(route('admin.locations.create')); ?>" class="inline-flex items-center px-4 py-2 bg-primary hover:bg-primary-dark text-white text-sm font-medium rounded-md transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                        </svg>
                        Add Location
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
                                    <th class="text-left text-xs font-medium text-slate-500 uppercase tracking-wide px-5 py-3">District</th>
                                    <th class="text-left text-xs font-medium text-slate-500 uppercase tracking-wide px-5 py-3">Province</th>
                                    <th class="text-left text-xs font-medium text-slate-500 uppercase tracking-wide px-5 py-3">Status</th>
                                    <th class="text-left text-xs font-medium text-slate-500 uppercase tracking-wide px-5 py-3">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50">
                                <?php $__empty_1 = true; $__currentLoopData = $locations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $location): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr class="hover:bg-slate-50/50">
                                    <td class="px-5 py-3 text-sm font-medium text-slate-900"><?php echo e($location->name); ?></td>
                                    <td class="px-5 py-3 text-sm text-slate-600"><?php echo e($location->district); ?></td>
                                    <td class="px-5 py-3 text-sm text-slate-600"><?php echo e($location->province); ?></td>
                                    <td class="px-5 py-3">
                                        <span class="inline-flex items-center px-2 py-0.5 text-xs font-medium rounded-md
                                            <?php echo e($location->status == 'active' ? 'bg-emerald-50 text-emerald-700' : 'bg-red-50 text-red-700'); ?>">
                                            <?php echo e(ucfirst($location->status)); ?>

                                        </span>
                                    </td>
                                    <td class="px-5 py-3">
                                        <a href="<?php echo e(route('admin.locations.show', $location->id)); ?>" class="text-primary hover:text-primary-dark text-sm font-medium">View</a>
                                        <a href="<?php echo e(route('admin.locations.edit', $location->id)); ?>" class="ml-3 text-slate-600 hover:text-slate-900 text-sm font-medium">Edit</a>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="5" class="px-5 py-12 text-center">
                                        <div class="w-12 h-12 bg-slate-100 rounded-md flex items-center justify-center mx-auto mb-3">
                                            <i class="fas fa-map-marker-alt text-slate-400"></i>
                                        </div>
                                        <h3 class="text-sm font-medium text-slate-900 mb-1">No locations found</h3>
                                        <p class="text-xs text-slate-500">Get started by adding a new location.</p>
                                    </td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="px-5 py-4 border-t border-slate-100">
                        <?php echo e($locations->links()); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH H:\bus-ticket-booking-system\resources\views/admin/locations/index.blade.php ENDPATH**/ ?>