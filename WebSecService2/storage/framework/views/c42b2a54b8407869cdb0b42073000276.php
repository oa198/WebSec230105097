<?php $__env->startSection('title', 'Purchase History'); ?>
<?php $__env->startSection('content'); ?>

<div class="row mt-2 mb-4">
    <div class="col col-10">
        <h1>Purchase History</h1>
    </div>
</div>

<?php if(session('success')): ?>
    <div class="alert alert-success mt-3">
        <?php echo e(session('success')); ?>

    </div>
<?php endif; ?>
<?php if(session('error')): ?>
    <div class="alert alert-danger mt-3">
        <?php echo e(session('error')); ?>

    </div>
<?php endif; ?>

<div class="card mt-3">
    <div class="card-body">
        <table class="table table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Purchase Date</th>
                    <th>Status</th>
                    <th>Status Messages</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $purchases; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $purchase): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($purchase->product->name); ?></td>
                    <td><?php echo e($purchase->quantity); ?></td>
                    <td><?php echo e($purchase->created_at->format('m/d/Y')); ?></td>
                    <td>
                        <span class="badge
                            <?php if($purchase->status == 'Pending'): ?> bg-warning text-dark
                            <?php elseif($purchase->status == 'Shipped'): ?> bg-info
                            <?php else: ?> bg-success
                            <?php endif; ?>">
                            <?php echo e($purchase->status ?? 'Pending'); ?>

                        </span>
                    </td>
                    <td>
                        <button class="btn btn-sm btn-outline-primary" type="button" data-bs-toggle="collapse" data-bs-target="#statusMessages<?php echo e($purchase->id); ?>" aria-expanded="false" aria-controls="statusMessages<?php echo e($purchase->id); ?>">
                            <i class="fas fa-history"></i> View Updates (<?php echo e($purchase->statusMessages->count()); ?>)
                        </button>
                        <div class="collapse mt-2" id="statusMessages<?php echo e($purchase->id); ?>">
                            <div class="card card-body">
                                <?php if($purchase->statusMessages->count() > 0): ?>
                                    <ul class="list-group list-group-flush">
                                        <?php $__currentLoopData = $purchase->statusMessages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <li class="list-group-item">
                                                <small>
                                                    <strong><?php echo e($message->created_at->format('m/d/Y H:i')); ?>:</strong> <?php echo e($message->message); ?>

                                                </small>
                                            </li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </ul>
                                <?php else: ?>
                                    <small class="text-muted">No status updates yet.</small>
                                <?php endif; ?>
                            </div>
                        </div>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="5" class="text-center">No purchases found</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\WebSec230105097\New folder\websec-main\WebSecService\resources\views/purchases/list.blade.php ENDPATH**/ ?>