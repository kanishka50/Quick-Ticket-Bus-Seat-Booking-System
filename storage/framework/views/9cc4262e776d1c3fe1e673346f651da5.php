

<?php $__env->startSection('content'); ?>
<div class="bg-surface min-h-screen">
    <div class="container mx-auto px-4 max-w-7xl py-6">
        <div class="flex flex-col lg:flex-row gap-6">
            <!-- Sidebar -->
            <?php echo $__env->make('partials.user-sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

            <!-- Main Content -->
            <div class="flex-1 min-w-0">
                <!-- Validation Errors -->
                <?php if($errors->any()): ?>
                    <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-md text-sm mb-6 flex items-start gap-3">
                        <i class="fas fa-exclamation-circle mt-0.5 shrink-0"></i>
                        <div>
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <p><?php echo e($error); ?></p>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Update Profile -->
                <div class="bg-white border border-slate-100 rounded-md shadow-sm mb-6">
                    <div class="px-5 py-4 border-b border-slate-100">
                        <h1 class="text-lg font-semibold text-slate-900">Edit Profile</h1>
                        <p class="text-xs text-slate-500 mt-0.5">Update your personal information.</p>
                    </div>

                    <form method="POST" action="<?php echo e(route('profile.update')); ?>" enctype="multipart/form-data" class="p-5">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>

                        <!-- Profile Photo -->
                        <div class="flex items-center gap-5 mb-6 pb-6 border-b border-slate-100">
                            <div class="relative">
                                <div class="w-20 h-20 rounded-md overflow-hidden bg-slate-100">
                                    <img id="profile-preview"
                                         src="<?php echo e(auth()->user()->profile_image ? asset('storage/' . auth()->user()->profile_image) : asset('images/default-profile.png')); ?>"
                                         alt="Profile Photo"
                                         class="w-full h-full object-cover">
                                </div>
                                <label for="profile_image" class="absolute -bottom-1 -right-1 w-7 h-7 bg-primary text-white rounded-md flex items-center justify-center cursor-pointer hover:bg-primary-dark transition-colors shadow-sm">
                                    <i class="fas fa-camera text-xs"></i>
                                </label>
                                <input id="profile_image" type="file" name="profile_image" class="hidden" accept="image/*">
                            </div>
                            <div>
                                <p class="text-sm font-medium text-slate-900">Profile Photo</p>
                                <p class="text-xs text-slate-500 mt-0.5">JPG, PNG or GIF. Max 2MB.</p>
                            </div>
                        </div>

                        <div class="grid sm:grid-cols-2 gap-5">
                            <!-- Name -->
                            <div>
                                <label for="name" class="block text-sm font-medium text-slate-700 mb-1.5">Name</label>
                                <input id="name" type="text" name="name" value="<?php echo e(auth()->user()->name); ?>" required
                                    class="w-full px-3 py-2 border border-slate-200 rounded-md text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors">
                                <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="mt-1 text-xs text-red-600"><?php echo e($message); ?></p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-medium text-slate-700 mb-1.5">Email</label>
                                <input id="email" type="email" name="email" value="<?php echo e(auth()->user()->email); ?>" required
                                    class="w-full px-3 py-2 border border-slate-200 rounded-md text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors">
                                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="mt-1 text-xs text-red-600"><?php echo e($message); ?></p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <!-- Phone Number -->
                            <div>
                                <label for="phone_number" class="block text-sm font-medium text-slate-700 mb-1.5">Phone Number</label>
                                <input id="phone_number" type="text" name="phone_number" value="<?php echo e(auth()->user()->phone_number); ?>"
                                    class="w-full px-3 py-2 border border-slate-200 rounded-md text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors">
                                <?php $__errorArgs = ['phone_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="mt-1 text-xs text-red-600"><?php echo e($message); ?></p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <!-- Address -->
                            <div>
                                <label for="address" class="block text-sm font-medium text-slate-700 mb-1.5">Address</label>
                                <textarea id="address" name="address" rows="1"
                                    class="w-full px-3 py-2 border border-slate-200 rounded-md text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors"><?php echo e(auth()->user()->address); ?></textarea>
                                <?php $__errorArgs = ['address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="mt-1 text-xs text-red-600"><?php echo e($message); ?></p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end">
                            <button type="submit" class="inline-flex items-center px-5 py-2 bg-primary text-white text-sm font-medium rounded-md hover:bg-primary-dark transition-colors">
                                <i class="fas fa-save mr-2 text-xs"></i> Update Profile
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Change Password -->
                <div class="bg-white border border-slate-100 rounded-md shadow-sm">
                    <div class="px-5 py-4 border-b border-slate-100">
                        <h2 class="text-lg font-semibold text-slate-900">Change Password</h2>
                        <p class="text-xs text-slate-500 mt-0.5">Ensure your account is using a strong password.</p>
                    </div>

                    <form method="POST" action="<?php echo e(route('profile.password')); ?>" class="p-5">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>

                        <div class="grid sm:grid-cols-2 gap-5 max-w-xl">
                            <div class="sm:col-span-2">
                                <label for="current_password" class="block text-sm font-medium text-slate-700 mb-1.5">Current Password</label>
                                <input id="current_password" type="password" name="current_password" required
                                    class="w-full px-3 py-2 border border-slate-200 rounded-md text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors">
                                <?php $__errorArgs = ['current_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="mt-1 text-xs text-red-600"><?php echo e($message); ?></p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div>
                                <label for="password" class="block text-sm font-medium text-slate-700 mb-1.5">New Password</label>
                                <input id="password" type="password" name="password" required
                                    class="w-full px-3 py-2 border border-slate-200 rounded-md text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors">
                                <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="mt-1 text-xs text-red-600"><?php echo e($message); ?></p>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div>
                                <label for="password_confirmation" class="block text-sm font-medium text-slate-700 mb-1.5">Confirm Password</label>
                                <input id="password_confirmation" type="password" name="password_confirmation" required
                                    class="w-full px-3 py-2 border border-slate-200 rounded-md text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors">
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end">
                            <button type="submit" class="inline-flex items-center px-5 py-2 bg-slate-800 text-white text-sm font-medium rounded-md hover:bg-slate-900 transition-colors">
                                <i class="fas fa-lock mr-2 text-xs"></i> Change Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('profile_image').addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('profile-preview').src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH H:\bus-ticket-booking-system\resources\views/profile.blade.php ENDPATH**/ ?>