<?php $__env->startSection('title', 'User Profile'); ?>
<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="m-4 col-sm-6">
        <?php if(session('success')): ?>
            <div class="alert alert-success"><?php echo e(session('success')); ?></div>
        <?php endif; ?>
        <?php if(session('error')): ?>
            <div class="alert alert-danger"><?php echo e(session('error')); ?></div>
        <?php endif; ?>

        <table class="table table-striped">
            <tr><th>Name</th><td><?php echo e($user->name); ?></td></tr>
            <tr><th>Email</th><td><?php echo e($user->email); ?></td></tr>
            <tr><th>Credit</th><td>$<?php echo e(number_format($user->credit, 2)); ?></td></tr>
            <tr><th>Roles</th><td>
                <?php $__currentLoopData = $user->roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <span class="badge bg-primary"><?php echo e($role->name); ?></span>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </td></tr>
        </table>

        <h3>Purchased Products</h3>
        <?php if($user->purchases->count() > 0): ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Purchase Date</th>
                        <th>Status</th>
                        <th>Status Updates</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $user->purchases; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $purchase): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($purchase->id); ?></td>
                        <td><?php echo e($purchase->product->name); ?></td>
                        <td>$<?php echo e(number_format($purchase->purchase_price, 2)); ?></td>
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
                                                    <strong><?php echo e(Carbon\Carbon::parse($message->created_at)->format('m/d/Y H:i')); ?>:</strong>

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
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No purchases yet.</p>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\WebSec230105097\New folder\websec-main\WebSecService\resources\views/users/profile.blade.php ENDPATH**/ ?>