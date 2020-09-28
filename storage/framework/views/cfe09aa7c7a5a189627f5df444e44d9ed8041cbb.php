

<?php $__env->startSection('content'); ?>


<div class="container">
    <h1>Seller Shops</h1>
        <table>
            <tr>
                <td>Toko Terverivikasi</td>
                <td> : </td>
                <td> <?php echo e($count); ?> </td>
            </tr>
        </table><br><br><hr>
        <div class="table-responsive text-nowrap">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID.</th>
                        <th>Nama Toko</th>
                        <th>Nama Pemilik</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $nomor=1; ?>
                    <?php $__currentLoopData = $shops; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $shop): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e($shop->id); ?></td>
                        <td><?php echo e($shop->shop); ?></td>
                        <td><?php echo e($shop->user); ?></td>
                        <?php $nomor++; ?>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
</div>

<div class="container">
    <h1>Driver Shop</h1>
    <table>
        <tr>
            <td>Toko Dengan Driver</td>
            <td> : </td>
            <td> <?php echo e($counts); ?> </td>
        </tr>
    </table>
    <div class="table-responsive text-nowrap">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No. </th>
                    <th>Nama Toko</th>
                    <th>Driver</th>
                </tr>
            </thead>
            <tbody>
                <?php $nomor=1; ?>
                <?php $__currentLoopData = $drivers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo $nomor;?></td>
                        <td><?php echo e($d->shop); ?></td>
                        <td><?php echo e($d->driver); ?></td>
                        <?php $nomor++; ?>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/admin/dev.tajeer.id/devtajeer/resources/views/shops.blade.php ENDPATH**/ ?>