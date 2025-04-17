<?php $__env->startSection('title', 'Products'); ?>
<?php $__env->startSection('content'); ?>

<div class="row mt-2 mb-4">
    <div class="col col-10">
        <h1>Products Inventory</h1>
    </div>
    <div class="col col-2">
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('add_products')): ?>
        <a href="<?php echo e(route('products.create')); ?>" class="btn btn-success btn-sm form-control">
            <i class="fas fa-plus"></i> Add Product
        </a>
        <?php endif; ?>
    </div>
</div>


<?php if(auth()->check() && auth()->user()->hasRole('Customer')): ?>
<div class="alert alert-info mb-4">
    <i class="fas fa-wallet"></i> <strong>Available Credit:</strong> $<?php echo e(number_format(auth()->user()->credit, 2, '.', ',')); ?>

</div>
<?php endif; ?>

<div class="row">
    <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="col-md-6 col-lg-4 mb-4">
        <div class="card h-100">
            <div class="card-img-top-container" style="height: 200px; overflow: hidden;">
                <img src="<?php echo e(asset('image/' . $product->photo)); ?>"
                     class="card-img-top img-fluid p-2"
                     alt="<?php echo e($product->name); ?>"
                     style="object-fit: contain; height: 100%; width: 100%;">
            </div>
            <div class="card-body">
                <h5 class="card-title"><?php echo e($product->name); ?></h5>
                <h6 class="card-subtitle mb-2 text-muted">Model: <?php echo e($product->model); ?></h6>
                <div class="product-meta mb-3">
                    <span class="badge bg-primary">Code: <?php echo e($product->code); ?></span>
                    <span class="badge <?php echo e($product->stock > 0 ? 'bg-success' : 'bg-danger'); ?> ms-2">
                        Stock: <?php echo e($product->stock); ?>

                    </span>
                </div>
                <p class="card-text text-truncate"><?php echo e($product->description); ?></p>
                <div class="d-flex justify-content-between align-items-center">
                    <h4 class="text-primary mb-0">$<?php echo e(number_format($product->price, 2, '.', ',')); ?></h4>

                    <div class="btn-group">
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit_products')): ?>
                        <a href="<?php echo e(route('products.edit', $product->id)); ?>"
                           class="btn btn-sm btn-outline-secondary">
                           <i class="fas fa-edit"></i>
                        </a>
                        <?php endif; ?>

                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete_products')): ?>
                        <form action="<?php echo e(route('products.delete', $product->id)); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                        <?php endif; ?>
                    </div>
                </div>

                <?php if(auth()->check() && auth()->user()->hasRole('Customer')): ?>
                    <?php if($product->stock > 0): ?>
                        <?php if(auth()->user()->credit >= $product->price): ?>
                            <form action="<?php echo e(route('products.buy', $product->id)); ?>" method="POST" class="mt-3">
                                <?php echo csrf_field(); ?>
                                <div class="input-group">
                                    <input type="number"
                                           name="quantity"
                                           value="1"
                                           min="1"
                                           max="<?php echo e($product->stock); ?>"
                                           class="form-control form-control-sm">
                                    <button type="submit" class="btn btn-primary btn-sm">
                                        <i class="fas fa-cart-plus"></i> Buy
                                    </button>
                                </div>
                            </form>
                        <?php else: ?>
                            <div class="alert alert-warning mt-3 p-2">
                                <small>
                                    <i class="fas fa-exclamation-triangle"></i>
                                    Need $<?php echo e(number_format($product->price - auth()->user()->credit, 2, '.', ',')); ?> more
                                </small>
                            </div>
                        <?php endif; ?>
                    <?php else: ?>
                        <div class="alert alert-danger mt-3 p-2">
                            <small>
                                <i class="fas fa-times-circle"></i> Out of stock
                            </small>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
            <div class="card-footer bg-transparent">
                <small class="text-muted">
                    Last updated: <?php echo e($product->updated_at ? $product->updated_at->diffForHumans() : 'Never'); ?>

                </small>
            </div>
        </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\WebSec230105097\New folder\websec-main\WebSecService\resources\views/products/list.blade.php ENDPATH**/ ?>