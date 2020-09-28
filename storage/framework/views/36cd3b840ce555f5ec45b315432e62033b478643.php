<?php $__env->startSection('content'); ?>
    <div class="card-body login-card-body">
        <p class="login-box-msg"><?php echo e(__('auth.reset_title')); ?></p>

        <?php if(session('status')): ?>
            <div class="alert alert-success" role="alert">
                <?php echo e(session('status')); ?>

            </div>
        <?php endif; ?>

        <form method="post" action="<?php echo e(url('password/email')); ?>">
            <?php echo csrf_field(); ?>


            <div class="input-group mb-3">
                <input value="<?php echo e(old('email')); ?>" type="email" class="form-control <?php echo e($errors->has('email') ? ' is-invalid' : ''); ?>" name="email" placeholder="<?php echo e(__('auth.email')); ?>" aria-label="<?php echo e(__('auth.email')); ?>">
                <div class="input-group-append">
                    <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                </div>
                <?php if($errors->has('email')): ?>
                    <div class="invalid-feedback">
                        <?php echo e($errors->first('email')); ?>

                    </div>
                <?php endif; ?>
            </div>
            <div class="row mb-3 ">
                <!-- /.col -->
                <div class="col-9 m-auto">
                    <button type="submit" class="btn btn-primary btn-block"><?php echo e(__('auth.send_password')); ?></button>
                </div>
                <!-- /.col -->
            </div>
        </form>
        <p class="mb-0 text-center">
            <a href="<?php echo e(url('/login')); ?>" class="text-center"><?php echo e(__('auth.remember_password')); ?></a>
        </p>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.auth.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/admin/dev.tajeer.id/devtajeer/resources/views/auth/passwords/email.blade.php ENDPATH**/ ?>