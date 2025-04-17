<?php $__env->startSection('title', 'Users'); ?>
<?php $__env->startSection('content'); ?>

<div class="row mt-2">
    <div class="col col-10">
        <h1>Users Management</h1>
    </div>
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('create_employees')): ?>
    <div class="col col-2 text-end">
        <a href="<?php echo e(route('users.create')); ?>" class="btn btn-success">Create Employee</a>
    </div>
    <?php endif; ?>
</div>

<form method="GET" action="<?php echo e(route('users')); ?>">
    <div class="row mt-3">
        <div class="col col-sm-3">
            <input name="keywords" type="text" class="form-control"
                   placeholder="Search by name or email" value="<?php echo e(request()->keywords); ?>" />
        </div>
        <div class="col col-sm-3">
            <select name="role" class="form-select">
                <option value="">All Users</option>
                <option value="Customer" <?php echo e(request()->role == 'Customer' ? 'selected' : ''); ?>>Customers</option>
                <option value="Employee" <?php echo e(request()->role == 'Employee' ? 'selected' : ''); ?>>Employees</option>
                <option value="Admin" <?php echo e(request()->role == 'Admin' ? 'selected' : ''); ?>>Admins</option>
            </select>
        </div>
        <div class="col col-sm-2">
            <button type="submit" class="btn btn-primary w-100">Filter</button>
        </div>
        <div class="col col-sm-2">
            <a href="<?php echo e(route('users')); ?>" class="btn btn-danger w-100">Reset</a>
        </div>
    </div>
</form>

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
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Credit</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($user->id); ?></td>
                    <td><?php echo e($user->name); ?></td>
                    <td><?php echo e($user->email); ?></td>
                    <td>
                        <?php $__currentLoopData = $user->roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <span class="badge
                                <?php if($role->name == 'Admin'): ?> bg-danger
                                <?php elseif($role->name == 'Employee'): ?> bg-warning text-dark
                                <?php else: ?> bg-primary
                                <?php endif; ?>">
                                <?php echo e($role->name); ?>

                            </span>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </td>
                    <td>
                        <?php if($user->hasRole('Customer')): ?>
                            $<?php echo e(number_format($user->credit, 2)); ?>

                        <?php else: ?>
                            -
                        <?php endif; ?>
                    </td>
                    <td>
                        <div class="d-flex gap-2">
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit_users')): ?>
                            <a href="<?php echo e(route('users_edit', $user->id)); ?>" class="btn btn-sm btn-primary">
                                <i class="fas fa-edit"></i>
                            </a>
                            <?php endif; ?>

                            <?php if(auth()->user()->can('add_credit') && $user->hasRole('Customer')): ?>
                            <button class="btn btn-sm btn-info" data-bs-toggle="modal"
                                    data-bs-target="#creditModal<?php echo e($user->id); ?>">
                                <i class="fas fa-plus-circle"></i>
                            </button>
                            <?php endif; ?>

                            <?php if(auth()->user()->can('track_delivery') && $user->hasRole('Customer')): ?>
                            <button class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                    data-bs-target="#statusModal<?php echo e($user->id); ?>">
                                <i class="fas fa-truck"></i>
                            </button>
                            <?php endif; ?>

                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete_users')): ?>
                            <form action="<?php echo e(route('users_delete', $user->id)); ?>" method="POST"
                                  onsubmit="return confirm('Are you sure?')">
                                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                            <?php endif; ?>
                        </div>

                        <!-- Add Credit Modal -->
                        <?php if(auth()->user()->can('add_credit') && $user->hasRole('Customer')): ?>
                        <div class="modal fade" id="creditModal<?php echo e($user->id); ?>" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form action="<?php echo e(route('users.add_credit', $user->id)); ?>" method="POST">
                                        <?php echo csrf_field(); ?>
                                        <div class="modal-header">
                                            <h5 class="modal-title">Add Credit to <?php echo e($user->name); ?></h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label class="form-label">Current Credit</label>
                                                <input type="text" class="form-control"
                                                       value="$<?php echo e(number_format($user->credit, 2)); ?>" readonly>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Amount to Add</label>
                                                <input type="number" name="amount" class="form-control"
                                                       min="0.01" step="0.01" max="9999999.99" required>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-primary">Add Credit</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>

                        <!-- Status Management Modal -->
                        <?php if(auth()->user()->can('track_delivery') && $user->hasRole('Customer')): ?>
                        <div class="modal fade" id="statusModal<?php echo e($user->id); ?>" tabindex="-1">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Manage Purchase Status for <?php echo e($user->name); ?></h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <?php if($user->purchases->count() > 0): ?>
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Product</th>
                                                        <th>Quantity</th>
                                                        <th>Purchase Date</th>
                                                        <th>Status</th>
                                                        <th>Status Messages</th>
                                                        <th>Add Message</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $__currentLoopData = $user->purchases; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $purchase): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <tr>
                                                        <td><?php echo e($purchase->product->name); ?></td>
                                                        <td><?php echo e($purchase->quantity); ?></td>
                                                        <td><?php echo e($purchase->created_at->format('m/d/Y')); ?></td>
                                                        <td>
                                                            <form action="<?php echo e(route('purchases.update_status', $purchase->id)); ?>" method="POST" class="d-inline">
                                                                <?php echo csrf_field(); ?>
                                                                <?php echo method_field('PATCH'); ?>
                                                                <select name="status" onchange="this.form.submit()" class="form-select form-select-sm">
                                                                    <option value="Pending" <?php echo e($purchase->status == 'Pending' ? 'selected' : ''); ?>>Pending</option>
                                                                    <option value="Shipped" <?php echo e($purchase->status == 'Shipped' ? 'selected' : ''); ?>>Shipped</option>
                                                                    <option value="Delivered" <?php echo e($purchase->status == 'Delivered' ? 'selected' : ''); ?>>Delivered</option>
                                                                </select>
                                                            </form>
                                                        </td>
                                                        <td>
                                                            <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#statusMessages<?php echo e($purchase->id); ?>" aria-expanded="false" aria-controls="statusMessages<?php echo e($purchase->id); ?>">
                                                                <i class="fas fa-history"></i> (<?php echo e($purchase->statusMessages->count()); ?>)
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
                                                        <td>
                                                            <form action="<?php echo e(route('purchases.add_status_message', $purchase->id)); ?>" method="POST" class="d-inline">
                                                                <?php echo csrf_field(); ?>
                                                                <div class="input-group input-group-sm">
                                                                    <input type="text" name="message" class="form-control" placeholder="Add status message" required>
                                                                    <button type="submit" class="btn btn-primary btn-sm">
                                                                        <i class="fas fa-plus"></i>
                                                                    </button>
                                                                </div>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </tbody>
                                            </table>
                                        <?php else: ?>
                                            <p>No purchases found for this user.</p>
                                        <?php endif; ?>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="6" class="text-center">No users found</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\WebSec230105097\New folder\websec-main\WebSecService\resources\views/users/list.blade.php ENDPATH**/ ?>