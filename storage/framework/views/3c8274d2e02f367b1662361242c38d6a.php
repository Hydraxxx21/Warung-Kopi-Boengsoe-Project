<?php $__env->startSection('content'); ?>

<div class="d-flex flex-column gap-4 p-4">
    <?php if(session('error')): ?>
    <div class="alert alert-danger">
        <?php echo e(session('error')); ?>

    </div>
    <?php endif; ?>

    <div class="position-relative">
        <!-- 🔙 Tombol Back -->
        <div class="position-absolute top-0 start-0 m-3 p-2 d-flex align-items-center justify-content-center"
            onclick="window.history.back();"
            style="background-color: #535353; border-radius: 50%; cursor: pointer; width: 36px; height: 36px;">
            <img src="<?php echo e(asset('assets/images/icon-back.webp')); ?>" alt="Back" style="width: 16px;">
        </div>
        <span class=" text-center d-flex flex-column mt-3">Apakah kamu yakin?</span>
    </div>


    <div class="d-flex flex-column gap-4 py-4 px-3 rounded" style="background-color: #D9D9D9;">
        <div class="d-flex flex-column gap-1">
            <span class="fw-bold fs-6 text-uppercase">nomor meja <?php echo e($guest['table_number'] ?? '-'); ?></span>
            <span class="fw-light" style="font-size: 16px;"><?php echo e($guest['name'] ?? '-'); ?></span>
        </div>
        <div class="d-flex flex-column gap-2 py-4" style="border-bottom: 2px solid #000;">

            <?php $totalOrder = 0; ?>

            <?php $__currentLoopData = $order['items']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $orderItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
            // Hitung harga dasar produk
            $productSubtotal = $orderItem['quantity'] * $orderItem['price'];

            // Hitung total harga toppings
            $toppingsTotal = 0;
            $toppings = $orderItem['toppings'] ?? [];

            // Jika toppings masih JSON string, decode dulu
            if (is_string($toppings)) {
            $toppings = json_decode($toppings, true);
            if (!is_array($toppings)) {
            $toppings = [];
            }
            }

            if (!empty($toppings)) {
            foreach ($toppings as $topping) {
            $toppingsTotal += floatval($topping['price'] ?? 0);
            }
            }

            // Total toppings dikalikan dengan quantity
            $toppingsSubtotal = $toppingsTotal * $orderItem['quantity'];

            // Subtotal keseluruhan per item = (harga produk + harga toppings) * quantity
            $itemSubtotal = $productSubtotal + $toppingsSubtotal;

            // Tambahkan ke total keseluruhan
            $totalOrder += $itemSubtotal;
            ?>

            <div class="d-flex flex-row justify-content-between">
                <div class="d-flex flex-column gap-1">
                    <span class="fs-6 fw-bold"><?php echo e($orderItem['name'] ?? 'Product Name'); ?></span>
                    <span style="font-size: 12px;">Qty: <?php echo e($orderItem['quantity'] ?? '-'); ?></span>
                    <span style="font-size: 12px;">
                        Topping:
                        <?php if(!empty($toppings)): ?>
                        <?php $__currentLoopData = $toppings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $topping): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php echo e($topping['name'] ?? 'Unknown'); ?><?php if(!$loop->last): ?>, <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php else: ?>
                        -
                        <?php endif; ?>
                    </span>
                    <span style="font-size: 12px;">Catatan: <?php echo e($orderItem['note'] ?? '-'); ?></span>

                    
                    <div style="font-size: 10px; color: #666;">
                        <div>Harga produk: Rp. <?php echo e(number_format($orderItem['price'], 0, ',', '.')); ?> x <?php echo e($orderItem['quantity']); ?></div>
                        <?php if($toppingsTotal > 0): ?>
                        <div>Harga topping: Rp. <?php echo e(number_format($toppingsTotal, 0, ',', '.')); ?> x <?php echo e($orderItem['quantity']); ?></div>
                        <?php endif; ?>
                    </div>
                </div>
                <span class="fw-bold">Rp. <?php echo e(number_format($itemSubtotal, 0, ',', '.')); ?></span>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            <div class="d-flex flex-row justify-content-between">
                <span class="fw-bold">Total</span>
                <span class="fw-bold">Rp. <?php echo e(number_format($totalOrder, 0, ',', '.')); ?></span>
            </div>
        </div>
        <div class="py-2 w-100">
            <form action="<?php echo e(route('order.storeOrder')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <button type="submit" class="w-100 btn py-2 text-white bg-main" style="border-radius: 50px;">
                    Kirim Pesanan
                </button>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\warkop-main\resources\views/pages/product/confirm.blade.php ENDPATH**/ ?>