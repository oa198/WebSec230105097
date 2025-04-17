<?php $__env->startSection('title', 'Create Employee'); ?>
<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-center">
  <div class="card m-4 col-sm-6">
    <div class="card-body">

      <form action="<?php echo e(route('users.create')); ?>" method="post">
        <?php echo e(csrf_field()); ?>


        
        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <div class="alert alert-danger">
            <strong>Error!</strong> <?php echo e($error); ?>

          </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        <div class="form-group mb-2">
          <label for="name" class="form-label">Name:</label>
          <input type="text" class="form-control" placeholder="name" name="name" required>
        </div>

        <div class="form-group mb-2">
          <label for="email" class="form-label">Email:</label>
          <input type="email" class="form-control" placeholder="email" name="email" required>
        </div>

        <div class="form-group mb-2">
          <label for="password" class="form-label">Password:</label>
          <input type="password" class="form-control" placeholder="password" name="password" required>
        </div>

        <div class="form-group mb-2">
          <label for="password_confirmation" class="form-label">Password Confirmation:</label>
          <input type="password" class="form-control" placeholder="Confirmation" name="password_confirmation" required>
        </div>

        <div class="form-group mb-2">
          <button type="submit" class="btn btn-primary">Add</button>
        </div>
      </form>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\WebSec230105097\New folder\websec-main\WebSecService\resources\views/users/create.blade.php ENDPATH**/ ?>