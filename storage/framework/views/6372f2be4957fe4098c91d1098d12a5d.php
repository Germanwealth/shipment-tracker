<?php $__env->startSection('title', 'Admin Dashboard - Shipment Tracker'); ?>

<?php $__env->startSection('content'); ?>
<div class="flex h-screen bg-gray-100">
    <!-- Sidebar -->
    <div class="w-64 bg-gray-900 text-white shadow-lg">
        <div class="p-6 border-b border-gray-800">
            <h1 class="text-2xl font-bold flex items-center gap-2">
                <i class="fas fa-box"></i> Shipment Tracker
            </h1>
        </div>

        <nav class="mt-6 px-4">
            <a href="<?php echo e(route('admin.shipments.index')); ?>" class="block px-4 py-3 rounded-lg <?php echo e(request()->routeIs('admin.shipments*') ? 'bg-blue-600' : 'hover:bg-gray-800'); ?> transition">
                <i class="fas fa-list mr-2"></i> All Shipments
            </a>
            <a href="<?php echo e(route('admin.shipments.create')); ?>" class="block px-4 py-3 rounded-lg mt-2 hover:bg-gray-800 transition">
                <i class="fas fa-plus mr-2"></i> Create Shipment
            </a>
            <form action="<?php echo e(route('admin.logout')); ?>" method="POST" class="mt-6">
                <?php echo csrf_field(); ?>
                <button type="submit" class="w-full text-left px-4 py-3 rounded-lg hover:bg-red-600 transition flex items-center gap-2">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </button>
            </form>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="flex-1 overflow-auto">
        <div class="p-8">
            <!-- Header -->
            <div class="mb-8">
                <h2 class="text-3xl font-bold text-gray-900"><?php echo $__env->yieldContent('page-title', 'Dashboard'); ?></h2>
                <p class="text-gray-600 mt-2"><?php echo $__env->yieldContent('page-subtitle', 'Manage your shipments and tracking updates'); ?></p>
            </div>

            <!-- Alerts -->
            <?php if($errors->any()): ?>
                <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                    <strong class="block mb-2"><i class="fas fa-exclamation-circle mr-2"></i> Please correct the following errors:</strong>
                    <ul class="list-disc list-inside">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>

            <?php if(session('success')): ?>
                <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg flex items-center justify-between">
                    <span><i class="fas fa-check-circle mr-2"></i> <?php echo e(session('success')); ?></span>
                    <button onclick="this.parentElement.style.display='none';" class="text-green-700 hover:text-green-900">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            <?php endif; ?>

            <?php echo $__env->yieldContent('admin-content'); ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/codecps/Desktop/tracker/resources/views/layouts/admin.blade.php ENDPATH**/ ?>