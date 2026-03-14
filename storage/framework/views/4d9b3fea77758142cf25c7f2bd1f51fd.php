

<?php $__env->startSection('content'); ?>
<div class="bg-surface min-h-screen">
    <div class="container mx-auto px-4 max-w-7xl py-8">
        <div class="flex flex-col lg:flex-row gap-6">
            <?php echo $__env->make('partials.provider-sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

            <!-- Main Content -->
            <div class="flex-1 min-w-0">
                <div class="mb-6">
                    <h1 class="text-xl font-bold text-slate-900">Company Profile</h1>
                    <p class="text-sm text-slate-500 mt-1">Update your company information</p>
                </div>

                <!-- Validation Errors -->
                <?php if($errors->any()): ?>
                    <div class="bg-red-50 border border-red-200 rounded-md p-4 mb-6">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-red-700">
                                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php echo e($error); ?><br>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </p>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if(session('success')): ?>
                    <div class="bg-emerald-50 border border-emerald-200 rounded-md p-4 mb-6">
                        <p class="text-sm text-emerald-700"><?php echo e(session('success')); ?></p>
                    </div>
                <?php endif; ?>

                <div class="bg-white border border-slate-100 rounded-md shadow-sm p-6">
                    <form method="POST" action="<?php echo e(route('provider.update')); ?>" enctype="multipart/form-data" class="space-y-5">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>

                        <!-- Company Name -->
                        <div>
                            <label for="company_name" class="block text-sm font-medium text-slate-700 mb-1">Company Name</label>
                            <input id="company_name" type="text" name="company_name" value="<?php echo e(old('company_name', $provider->company_name)); ?>" required
                                class="w-full px-3 py-2 border border-slate-200 rounded-md text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none">
                        </div>

                        <!-- Business Registration Number -->
                        <div>
                            <label for="business_registration_number" class="block text-sm font-medium text-slate-700 mb-1">Business Registration Number</label>
                            <input id="business_registration_number" type="text" name="business_registration_number" value="<?php echo e(old('business_registration_number', $provider->business_registration_number)); ?>" required
                                class="w-full px-3 py-2 border border-slate-200 rounded-md text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none">
                        </div>

                        <!-- Contact Number -->
                        <div>
                            <label for="contact_number" class="block text-sm font-medium text-slate-700 mb-1">Contact Number</label>
                            <input id="contact_number" type="text" name="contact_number" value="<?php echo e(old('contact_number', $provider->contact_number)); ?>" required
                                class="w-full px-3 py-2 border border-slate-200 rounded-md text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none">
                        </div>

                        <!-- Address -->
                        <div>
                            <label for="address" class="block text-sm font-medium text-slate-700 mb-1">Business Address</label>
                            <textarea id="address" name="address" rows="2" required
                                class="w-full px-3 py-2 border border-slate-200 rounded-md text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none"><?php echo e(old('address', $provider->address)); ?></textarea>
                        </div>

                        <!-- Company Description -->
                        <div>
                            <label for="description" class="block text-sm font-medium text-slate-700 mb-1">Company Description</label>
                            <textarea id="description" name="description" rows="3"
                                class="w-full px-3 py-2 border border-slate-200 rounded-md text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none"><?php echo e(old('description', $provider->description)); ?></textarea>
                        </div>

                        <!-- Company Logo -->
                        <div>
                            <label for="company_logo" class="block text-sm font-medium text-slate-700 mb-1">Company Logo</label>
                            <div class="flex items-center gap-4">
                                <div class="relative">
                                    <div class="w-16 h-16 rounded-md overflow-hidden bg-slate-100 border border-slate-200">
                                        <img id="logo-preview"
                                             src="<?php echo e($provider->company_logo ? asset('storage/' . $provider->company_logo) : ''); ?>"
                                             alt="Company Logo"
                                             class="w-full h-full object-cover <?php echo e($provider->company_logo ? '' : 'hidden'); ?>">
                                        <div id="logo-placeholder" class="w-full h-full flex items-center justify-center <?php echo e($provider->company_logo ? 'hidden' : ''); ?>">
                                            <i class="fas fa-building text-slate-400 text-lg"></i>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <input type="file" id="company_logo" name="company_logo" accept="image/*"
                                        class="text-sm text-slate-600 file:mr-3 file:py-1.5 file:px-3 file:border file:border-slate-200 file:rounded-md file:text-sm file:font-medium file:bg-white file:text-slate-700 hover:file:bg-slate-50">
                                    <p class="text-xs text-slate-400 mt-1">JPG, PNG or GIF. Max 2MB.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div>
                            <button type="submit"
                                class="w-full py-2.5 px-4 bg-primary hover:bg-primary-dark text-white text-sm font-medium rounded-md transition-colors focus:ring-2 focus:ring-primary/20 focus:ring-offset-1">
                                Update Profile
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('company_logo').addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('logo-preview');
                const placeholder = document.getElementById('logo-placeholder');
                preview.src = e.target.result;
                preview.classList.remove('hidden');
                placeholder.classList.add('hidden');
            };
            reader.readAsDataURL(file);
        }
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH H:\bus-ticket-booking-system\resources\views/providers/edit.blade.php ENDPATH**/ ?>