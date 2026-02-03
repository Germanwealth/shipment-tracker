<?php $__env->startSection('title', 'Tracking Code Not Found - Nuelcargo'); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gray-50 flex items-center justify-center p-4">
    <div class="max-w-md w-full text-center">
        <!-- Error Icon -->
        <div class="mb-6">
            <i class="fas fa-exclamation-triangle text-6xl text-yellow-500"></i>
        </div>

        <!-- Error Message -->
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Tracking Code Not Found</h1>
        <p class="text-gray-600 mb-6">
            The tracking code <span class="font-mono text-lg font-bold text-red-600"><?php echo e($trackingCode); ?></span> could not be found in our system.
        </p>

        <!-- Suggestions -->
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-8 text-left">
            <p class="font-semibold text-gray-900 mb-3">Here are some things you can try:</p>
            <ul class="text-sm text-gray-700 space-y-2">
                <li>✓ Double-check the tracking code from your shipment label</li>
                <li>✓ Make sure there are no extra spaces or characters</li>
                <li>✓ The tracking code is case-insensitive (e.g., TRK-ABC or trk-abc work the same)</li>
                <li>✓ Your shipment may not have been added to the system yet</li>
            </ul>
        </div>

        <!-- Actions -->
        <div class="space-y-3">
            <a href="<?php echo e(route('tracking.index')); ?>" class="inline-block w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg transition">
                <i class="fas fa-search mr-2"></i> Try Another Code
            </a>
            <a href="<?php echo e(route('tracking.index')); ?>" class="inline-block w-full bg-gray-300 hover:bg-gray-400 text-gray-700 font-bold py-3 px-6 rounded-lg transition">
                <i class="fas fa-home mr-2"></i> Go Home
            </a>
        </div>

        <!-- Support -->
        <p class="text-gray-600 text-sm mt-8">
            Still having issues? <a href="#" class="text-blue-600 hover:underline">Contact our support team</a>
        </p>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.public', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/codecps/Desktop/tracker/resources/views/tracking/not-found.blade.php ENDPATH**/ ?>