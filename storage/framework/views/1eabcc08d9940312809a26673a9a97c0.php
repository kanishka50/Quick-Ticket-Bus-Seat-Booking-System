<?php $__env->startSection('content'); ?>
<div class="bg-surface min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full">
        <div class="bg-white border border-slate-100 rounded-md shadow-sm p-8">
            <div class="mb-6">
                <h2 class="text-2xl font-bold text-slate-900">Welcome Back</h2>
                <p class="mt-1 text-sm text-slate-500">
                    Don't have an account?
                    <a href="<?php echo e(route('register')); ?>" class="font-medium text-primary hover:text-primary-dark">Sign up</a>
                </p>
            </div>

            <?php if(session('success')): ?>
                <div class="bg-emerald-50 border border-emerald-200 rounded-md p-3 mb-4">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle text-emerald-500 mr-2 text-sm"></i>
                        <p class="text-sm text-emerald-700"><?php echo e(session('success')); ?></p>
                    </div>
                </div>
            <?php endif; ?>

            <?php if(session('error')): ?>
                <div class="bg-red-50 border border-red-200 rounded-md p-3 mb-4">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-circle text-red-500 mr-2 text-sm"></i>
                        <p class="text-sm text-red-700"><?php echo e(session('error')); ?></p>
                    </div>
                </div>
            <?php endif; ?>

            <?php if($errors->any()): ?>
                <div class="bg-red-50 border border-red-200 rounded-md p-3 mb-4">
                    <div class="flex items-start">
                        <i class="fas fa-exclamation-circle text-red-500 mr-2 text-sm mt-0.5"></i>
                        <div class="text-sm text-red-700">
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php echo e($error); ?><br>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <form method="POST" action="<?php echo e(route('login')); ?>" class="space-y-4">
                <?php echo csrf_field(); ?>

                <div>
                    <label for="email" class="block text-sm font-medium text-slate-700 mb-1">Email</label>
                    <input id="email" type="email" name="email" value="<?php echo e(old('email')); ?>" required autofocus
                        class="w-full px-3 py-2 border border-slate-200 rounded-md text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors">
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-slate-700 mb-1">Password</label>
                    <input id="password" type="password" name="password" required
                        class="w-full px-3 py-2 border border-slate-200 rounded-md text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-colors">
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember" name="remember" type="checkbox"
                            class="h-4 w-4 text-primary focus:ring-primary/20 border-slate-300 rounded">
                        <label for="remember" class="ml-2 block text-sm text-slate-600">Remember me</label>
                    </div>
                    <a href="<?php echo e(route('password.request')); ?>" class="text-sm font-medium text-primary hover:text-primary-dark">
                        Forgot password?
                    </a>
                </div>

                <button type="submit"
                    class="w-full flex justify-center py-2.5 px-4 bg-primary text-white text-sm font-medium rounded-md hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-colors">
                    Login
                </button>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH H:\bus-ticket-booking-system\resources\views/auth/login.blade.php ENDPATH**/ ?>