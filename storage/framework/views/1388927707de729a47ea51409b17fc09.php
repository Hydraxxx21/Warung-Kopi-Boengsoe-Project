<?php $__env->startSection('content'); ?>

<section class="position-relative d-flex flex-column gap-4" style="padding-bottom: 128px;">
    <div class="position-relative">
        <!-- Tombol Back -->
        <div class="position-absolute top-0 start-0 m-3 p-2 d-flex align-items-center justify-content-center"
            onclick="window.history.back();"
            style="background-color: #535353; border-radius: 50%; cursor: pointer; width: 36px; height: 36px;">
            <img src="<?php echo e(asset('assets/images/icon-back.webp')); ?>" alt="Back" style="width: 16px;">
        </div>

        <!-- Gambar -->
        <img src="<?php echo e(Storage::url($product->imageUrl)); ?>" alt="<?php echo e($product->name); ?>"
            class="w-100" style="height: 256px; object-fit: cover;">
    </div>

    <form action="<?php echo e(route('order.add')); ?>" method="POST" class="w-100">
        <?php echo csrf_field(); ?>
        <input type="hidden" name="product_id" value="<?php echo e($product->id); ?>">
        <input type="hidden" id="quantity" name="quantity" value="1">
        <input type="hidden" id="product-price" value="<?php echo e($product->price); ?>">
        <input type="hidden" id="imageUrl" value="<?php echo e($product->imageUrl); ?>">

        <div class="d-flex flex-column px-4 gap-2">
            <span class="fs-5 fw-bold"><?php echo e($product->name); ?></span>
            <span class="fw-light" style="font-size: 12px;"><?php echo e($product->description); ?></span>
            <span class="fs-5 fw-bold">Rp.<?php echo e(number_format($product->price, 0, ',', '.')); ?></span>


            <?php if($product->toppings->count() > 0): ?>
            <div class="mt-2">Topping</div>
            <div class="rounded p-3" style="border: 2px solid #000;">
                <?php $__currentLoopData = $product->toppings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $topping): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="d-flex align-items-start justify-content-between mb-3 custom-radio">
                    <div>
                        <div class="fw-bold"><?php echo e($topping->name); ?></div>
                        <div>Rp.<?php echo e(number_format($topping->price, 0, ',', '.')); ?></div>
                    </div>
                    <input class="form-check-input" type="checkbox"
                        name="toppings[]"
                        value="<?php echo e($topping->id); ?>"
                        data-price="<?php echo e($topping->price); ?>"
                        onchange="updateTotal()">
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <?php endif; ?>
        </div>

        <!-- Counter & Button -->
        <div class="d-flex justify-content-between align-items-center text-white position-fixed bottom-0 p-4 w-100"
            style="background-color: #D9D9D9; max-width: 512px;">

            <!-- Counter -->
            <div class="d-flex align-items-center bg-dark px-3 py-1 rounded-pill gap-3" style="font-size: 12px;">
                <button type="button" class="btn btn-light rounded-circle" onclick="changeQty(-1)">-</button>
                <span id="qty-display" class="px-2">1</span>
                <button type="button" class="btn btn-light rounded-circle" onclick="changeQty(1)">+</button>
            </div>

            <!-- Tombol Tambah -->
            <button type="submit" id="add-to-cart-btn" class="btn bg-main2 text-white px-2 py-3 rounded-pill"
                style="font-size: 12px;">
                Tambah - Rp <?php echo e(number_format($product->price, 0, ',', '.')); ?>

            </button>
        </div>
    </form>

</section>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
<script>
    let qty = 1;

    function changeQty(val) {
        qty = Math.max(1, qty + val);
        document.getElementById('qty-display').textContent = qty;
        document.getElementById('quantity').value = qty;
        updateTotal();
    }

    function updateTotal() {
        let productPrice = parseFloat(document.getElementById('product-price').value);
        let toppingPrices = document.querySelectorAll('input[name="toppings[]"]:checked');

        let toppingTotal = 0;
        toppingPrices.forEach(t => {
            toppingTotal += parseFloat(t.getAttribute('data-price'));
        });

        let total = (productPrice + toppingTotal) * qty;

        // update text button
        document.getElementById('add-to-cart-btn').textContent = "Tambah - Rp " + new Intl.NumberFormat('id-ID').format(total);
    }
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\warkop-main\resources\views/pages/product/index.blade.php ENDPATH**/ ?>