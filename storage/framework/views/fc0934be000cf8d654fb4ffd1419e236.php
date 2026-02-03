<?php $__env->startSection('page-title', 'All Shipments'); ?>
<?php $__env->startSection('page-subtitle', 'Manage and track all shipments'); ?>

<?php $__env->startSection('admin-content'); ?>
<div class="mb-6 flex justify-end">
    <a href="<?php echo e(route('admin.shipments.create')); ?>" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg transition flex items-center gap-2">
        <i class="fas fa-plus"></i> Create New Shipment
    </a>
</div>

<!-- Shipments Table -->
<div class="bg-white rounded-lg shadow-md overflow-hidden">
    <?php if($shipments->count() > 0): ?>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-100 border-b">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Tracking Code</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Sender</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Receiver</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Status</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Expected Delivery</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    <?php $__currentLoopData = $shipments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $shipment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 font-mono text-sm font-bold text-blue-600">
                                <?php echo e($shipment->tracking_code); ?>

                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700"><?php echo e($shipment->sender_name); ?></td>
                            <td class="px-6 py-4 text-sm text-gray-700"><?php echo e($shipment->receiver_name); ?></td>
                            <td class="px-6 py-4 text-sm">
                                <span class="px-3 py-1 rounded-full text-white text-xs font-semibold 
                                    <?php if($shipment->current_status === 'Delivered'): ?>
                                        bg-green-500
                                    <?php elseif($shipment->current_status === 'In Transit'): ?>
                                        bg-blue-500
                                    <?php else: ?>
                                        bg-yellow-500
                                    <?php endif; ?>
                                ">
                                    <?php echo e($shipment->current_status); ?>

                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700">
                                <?php echo e($shipment->expected_delivery_date->format('M d, Y')); ?>

                            </td>
                            <td class="px-6 py-4 text-sm space-x-2">
                                <a href="<?php echo e(route('admin.shipments.edit', $shipment)); ?>" class="inline-block px-3 py-1 bg-blue-500 hover:bg-blue-600 text-white rounded-lg transition text-xs font-semibold">
                                    <i class="fas fa-edit mr-1"></i> Edit
                                </a>
                                <a href="<?php echo e(route('admin.shipments.updates', $shipment)); ?>" class="inline-block px-3 py-1 bg-purple-500 hover:bg-purple-600 text-white rounded-lg transition text-xs font-semibold">
                                    <i class="fas fa-history mr-1"></i> Updates
                                </a>
                                <form action="<?php echo e(route('admin.shipments.destroy', $shipment)); ?>" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this shipment?');">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="px-3 py-1 bg-red-500 hover:bg-red-600 text-white rounded-lg transition text-xs font-semibold">
                                        <i class="fas fa-trash mr-1"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-6 py-4 border-t bg-gray-50">
            <?php echo e($shipments->links()); ?>

        </div>
    <?php else: ?>
        <div class="p-8 text-center">
            <i class="fas fa-inbox text-6xl text-gray-300 mb-4 block"></i>
            <p class="text-gray-600 text-lg mb-4">No shipments yet.</p>
            <a href="<?php echo e(route('admin.shipments.create')); ?>" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg transition">
                Create Your First Shipment
            </a>
        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/codecps/Desktop/tracker/resources/views/admin/dashboard.blade.php ENDPATH**/ ?>