<?php echo $__env->make('layouts.navbar-admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('layouts.sidebar-admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<div class="main-content mt-5">
    <?php if(session('success')): ?>
    <div class="alert alert-success">
        <?php echo e(session('success')); ?>

    </div>
    <?php endif; ?>
    <?php if(session('error')): ?>
    <div class="alert alert-danger">
        <?php echo e(session('error')); ?>

    </div>
    <?php endif; ?>
    <div class="container-fluid d-flex flex-column gap-4">
        <div class="d-flex flex-row justify-content-between align-items-center">
            <span class="fs-5 fw-semibold">Order Number #<?php echo e($order->id); ?></span>
            <a href="<?php echo e(route('pemesanan.index')); ?>" class="d-flex flex-row justify-content-between align-items-center gap-1 btn btn-sm btn-secondary">
                <i class="fa-solid fa-arrow-left"></i>
                <span>Kembali</span>
            </a>
        </div>
        <div class="row gap-2">

            <div class="col-md-7 table-responsive">
                <div class="bg-white border border-dark rounded-lg overflow-hidden">
                    <table class="table mb-0 text-center">
                        <thead>
                            <tr>
                                <th class="text-start" colspan="4">Pesanan</th>
                                <th>QTY</th>
                                <th>Harga</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $order->orderItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $orderItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="align-middle">
                                <td colspan="4">
                                    <div class="d-flex flex-row gap-2 align-items-center">
                                        <img src="<?php echo e(Storage::url($orderItem->product->imageUrl)); ?>" alt="img" class="rounded" style="width: 80px; height: 80px; object-fit: cover;">
                                        <span class="text-start"><?php echo e($orderItem->product->name); ?></span>
                                    </div>
                                </td>
                                <td>
                                    <span><?php echo e($orderItem->quantity); ?></span>
                                </td>
                                <td>
                                    <span>Rp. <?php echo e(number_format($orderItem->product->price, 0, ',', '.')); ?></span>
                                </td>
                                <td>
                                    <span>Rp. <?php echo e(number_format($orderItem->price, 0, ',', '.')); ?></span>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="col-md-4">
                <div class="bg-white border border-dark rounded-lg">
                    <div class="d-flex flex-column gap-2 p-2">
                        <span class="fs-6 fw-bold pb-3">Detail Pesanan</span>
                        <div class="d-flex flex-row justify-content-between">
                            <span>Pesanan dibuat</span>
                            <span><?php echo e(date_format($order->created_at, 'd F Y')); ?></span>
                        </div>
                        <div class="d-flex flex-row justify-content-between">
                            <span>Waktu</span>
                            <span><?php echo e(date_format($order->created_at, 'H:i')); ?></span>
                        </div>
                        <div class="fw-semibold mt-4 d-flex flex-row justify-content-between">
                            <span>Total</span>
                            <span>Rp. <?php echo e(number_format($order->total_price, 0, ',', '.')); ?></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-7 table-responsive">
                <div class="d-flex flex-column bg-white border border-dark rounded-lg overflow-hidden p-2 gap-2">
                    <span>Detail Kostumer</span>
                    <div class="d-flex flex-row justify-content-between">
                        <span>Nama Kostumer</span>
                        <span class="text-capitalize"><?php echo e($order->name); ?></span>
                    </div>
                    <div class="d-flex flex-row justify-content-between">
                        <span>Nomor Meja</span>
                        <span><?php echo e($order->table_number); ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php echo $__env->make('layouts.header-admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\warkop-main\resources\views/admin/pemesanan/detail.blade.php ENDPATH**/ ?>