<?php $__env->startSection('content'); ?>

<div class="d-flex flex-column gap-4 p-4">
    <div class="d-flex flex-column gap-1 text-center">
        <span>Kitchen Sudah Menerima Pesananmu</span>
        <span>Status Pesanan:
            <span class="text-capitalize badge 
                <?php if($orderData->status == 'pending'): ?> bg-warning
                <?php elseif($orderData->status == 'processing'): ?> bg-info
                <?php elseif($orderData->status == 'ready'): ?> bg-primary
                <?php elseif($orderData->status == 'completed'): ?> bg-success
                <?php else: ?> bg-secondary
                <?php endif; ?>">
                <?php echo e($orderData->status); ?>

            </span>
        </span>
    </div>
    <div class="d-flex flex-column gap-4 py-4 px-3 rounded" style="background-color: #D9D9D9;">
        <div class="d-flex flex-column gap-1">
            <span class="fw-bold fs-6 text-uppercase">nomor meja <?php echo e($orderData->table_number ?? '-'); ?></span>
            <span class="fw-light" style="font-size: 16px;"><?php echo e($orderData->name ?? '-'); ?></span>
        </div>
        <div class="d-flex flex-column gap-2 py-4" style="border-bottom: 2px solid #000;">

            <?php $totalCalculated = 0; ?>

            <?php $__currentLoopData = $orderItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $orderItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
            // Hitung total harga toppings untuk item ini dari pivot table
            $toppingsPrice = 0;
            if($orderItem->toppings && $orderItem->toppings->count() > 0) {
            foreach($orderItem->toppings as $topping) {
            $toppingsPrice += $topping->pivot->price;
            }
            }

            // Total untuk item ini (sudah include toppings dari database)
            $itemTotalPrice = $orderItem->price;
            $totalCalculated += $itemTotalPrice;
            ?>

            <div class="d-flex flex-row justify-content-between">
                <div class="d-flex flex-column gap-1">
                    <span class="fs-6 fw-bold"><?php echo e($orderItem->product->name); ?></span>
                    <span style="font-size: 12px;">Qty: <?php echo e($orderItem->quantity); ?></span>

                    <?php if($orderItem->toppings && $orderItem->toppings->count() > 0): ?>
                    <span style="font-size: 12px;">
                        Topping:
                        <?php $__currentLoopData = $orderItem->toppings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $topping): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php echo e($topping->name); ?><?php if(!$loop->last): ?>, <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </span>
                    <?php endif; ?>

                    <?php if($orderItem->notes): ?>
                    <span style="font-size: 12px;">Catatan: <?php echo e($orderItem->notes); ?></span>
                    <?php endif; ?>

                    
                    <div style="font-size: 10px; color: #666;">
                        <div>Harga produk: Rp. <?php echo e(number_format($orderItem->product->price, 0, ',', '.')); ?> x <?php echo e($orderItem->quantity); ?></div>
                        <?php if($toppingsPrice > 0): ?>
                        <div>Harga topping: Rp. <?php echo e(number_format($toppingsPrice, 0, ',', '.')); ?> x <?php echo e($orderItem->quantity); ?></div>
                        <?php endif; ?>
                    </div>
                </div>
                <span class="fw-bold">Rp. <?php echo e(number_format($itemTotalPrice, 0, ',', '.')); ?></span>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        </div>

        <div class="d-flex flex-row justify-content-between">
            <span class="fw-bold">Total</span>
            <span class="fw-bold">Rp. <?php echo e(number_format($orderData->total_price, 0, ',', '.')); ?></span>
        </div>

        
        <div class="py-2 w-100 d-flex gap-2">
            <button onclick="window.location.reload()" class="flex-fill btn py-2 text-white bg-main3" style="border-radius: 50px;">
                Refresh Status
            </button>
            <?php if($orderData->status == 'completed'): ?>
            <button onclick="window.location.href = '<?php echo e(route('dashboard.index')); ?>'" class="flex-fill btn py-2 text-white" style="background-color: #28a745; border-radius: 50px;">
                Pesan Lagi
            </button>
            <?php endif; ?>
        </div>
    </div>
</div>


<script>
    // Auto refresh setiap 30 detik untuk cek status pesanan
    setTimeout(function() {
        if (['pending', 'processing', 'ready'].includes('<?php echo e($orderData->status); ?>')) {
            window.location.reload();
        }
    }, 30000);
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\warkop-main\resources\views/pages/product/wait.blade.php ENDPATH**/ ?>