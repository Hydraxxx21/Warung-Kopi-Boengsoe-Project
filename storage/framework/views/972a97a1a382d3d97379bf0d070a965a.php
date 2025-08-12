<?php $__env->startSection('content'); ?>
<section class="position-relative d-flex flex-column gap-4 pb-4">
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
        <span class="fs-4 fw-bold text-center d-flex flex-column mt-3">CHECKOUT</span>
    </div>

    <?php
    $subTotal = 0;
    ?>

    <!-- ✅ FORM -->
    <form action="<?php echo e(route('checkout.store')); ?>" method="POST">
        <?php echo csrf_field(); ?>

        <div class="d-flex flex-column gap-4 px-3">
            <?php if(is_array($order)): ?>
            <?php
            // Filter hanya index numerik (produk)
            $orderItems = array_filter($order, fn($v, $k) => is_int($k), ARRAY_FILTER_USE_BOTH);
            ?>
            <?php $__currentLoopData = $orderItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $orderItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
            $toppings = $orderItem['toppings'] ?? [];
            // Pastikan toppings adalah array
            if (is_string($toppings)) {
            $toppings = json_decode($toppings, true) ?: [];
            }

            $toppingTotal = 0;
            foreach ($toppings as $topping) {
            $toppingTotal += is_array($topping) ? ($topping['price'] ?? 0) : (is_object($topping) ? $topping->price : 0);
            }

            $productTotal = ($orderItem['price'] * $orderItem['quantity']) + ($toppingTotal * $orderItem['quantity']);
            $subTotal += $productTotal;
            ?>

            <!-- ✅ CARD ITEM -->
            <div class="d-flex flex-row rounded overflow-hidden p-3 gap-3 text-white order-card position-relative"
                style="min-height: 200px; background-color: #535353;"
                data-price="<?php echo e($orderItem['price']); ?>"
                data-topping="<?php echo e($toppingTotal); ?>"
                data-key="<?php echo e($key); ?>">

                <!-- ✅ Tombol Delete di pojok kanan atas -->
                <i class="fa-solid fa-circle-xmark position-absolute top-0 end-0 m-2 text-white cursor-pointer border-0 rounded-circle delete-item" data-key="<?php echo e($key); ?>"></i>

                <div class="d-flex flex-column gap-1" style="width: 35%;">
                    <img src="<?php echo e(isset($orderItem['imageUrl']) ? Storage::url($orderItem['imageUrl']) : asset('assets/images/bibimbap.webp')); ?>" alt="img" class="rounded" style="height: 100%; object-fit: cover;">

                    <!-- ✅ Quantity Box -->
                    <div class="d-flex flex-row gap-3 py-1 px-3 fw-bold text-black rounded justify-content-between align-items-center"
                        style="background-color: #D9D9D9; height: fit-content;">

                        <button type="button"
                            class="qty-btn border-0 bg-transparent fs-5"
                            data-key="<?php echo e($key); ?>" data-change="-1">−</button>

                        <span id="qty-display-<?php echo e($key); ?>"><?php echo e($orderItem['quantity']); ?></span>

                        <button type="button"
                            class="qty-btn border-0 bg-transparent fs-5"
                            data-key="<?php echo e($key); ?>" data-change="1">+</button>
                    </div>
                </div>

                <!-- ✅ Info Produk -->
                <div class="d-flex flex-column justify-content-between gap-2 flex-grow-1">
                    <div class="d-flex flex-row justify-content-between">
                        <div class="d-flex flex-column gap-1">
                            <span class="fs-6 fw-bold"><?php echo e($orderItem['name']); ?></span>
                            <span class="fw-bold">Rp. <?php echo e(number_format($orderItem['price'], 0, ',', '.')); ?></span>

                            <!-- ✅ Toppings -->
                            <?php if(!empty($toppings)): ?>
                            <small class="mt-1">Topping:</small>
                            <ul class="m-0 ps-3">
                                <?php $__currentLoopData = $toppings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $topping): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                $toppingName = is_array($topping) ? ($topping['name'] ?? '') : (is_object($topping) ? $topping->name : '');
                                $toppingPrice = is_array($topping) ? ($topping['price'] ?? 0) : (is_object($topping) ? $topping->price : 0);
                                ?>
                                <li><?php echo e($toppingName); ?> (+Rp<?php echo e(number_format($toppingPrice, 0, ',', '.')); ?>)</li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                            <?php endif; ?>

                            <!-- ✅ Total Per Item -->
                            <small class="mt-2 item-total">
                                Total Item: <b id="item-total-<?php echo e($key); ?>">Rp<?php echo e(number_format($productTotal, 0, ',', '.')); ?></b>
                            </small>
                        </div>
                    </div>

                    <!-- ✅ Catatan -->
                    <div class="d-flex flex-column gap-2">
                        <span class="fw-light fs-6">Catatan</span>
                        <input type="text" name="order_items[<?php echo e($key); ?>][note]" class="py-1 rounded border-none px-2"
                            placeholder="Catatan untuk produk ini" style="font-size: 12px;">
                    </div>
                </div>
            </div>


            <!-- ✅ Hidden Inputs (agar data terkirim) -->
            <input type="hidden" name="order_items[<?php echo e($key); ?>][product_id]" value="<?php echo e($orderItem['product_id']); ?>">
            <input type="hidden" name="order_items[<?php echo e($key); ?>][price]" value="<?php echo e($orderItem['price']); ?>">
            <input type="hidden" name="order_items[<?php echo e($key); ?>][quantity]" id="qty-input-<?php echo e($key); ?>" value="<?php echo e($orderItem['quantity']); ?>">

            <!-- ✅ Improved toppings handling -->
            <?php if(!empty($toppings)): ?>
            <?php $__currentLoopData = $toppings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $toppingIndex => $topping): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <input type="hidden" name="order_items[<?php echo e($key); ?>][toppings][<?php echo e($toppingIndex); ?>][id]" value="<?php echo e(is_array($topping) ? ($topping['id'] ?? '') : (is_object($topping) ? $topping->id : '')); ?>">
            <input type="hidden" name="order_items[<?php echo e($key); ?>][toppings][<?php echo e($toppingIndex); ?>][name]" value="<?php echo e(is_array($topping) ? ($topping['name'] ?? '') : (is_object($topping) ? $topping->name : '')); ?>">
            <input type="hidden" name="order_items[<?php echo e($key); ?>][toppings][<?php echo e($toppingIndex); ?>][price]" value="<?php echo e(is_array($topping) ? ($topping['price'] ?? 0) : (is_object($topping) ? $topping->price : 0)); ?>">
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php else: ?>
            <div class="text-center p-4">
                <p>Tidak ada pesanan untuk di-checkout.</p>
            </div>
            <?php endif; ?>
        </div>

        <!-- ✅ Bagian Total -->
        <div class="d-flex flex-column gap-2 px-3 pt-4">
            <div class="d-flex flex-row justify-content-between">
                <span class="fs-6 fw-bold">Sub Total</span>
                <span class="fs-6 fw-bold" id="subtotal">Rp. <?php echo e(number_format($subTotal, 0, ',', '.')); ?></span>
            </div>

            <div style="border-top: 2px dashed #000;"></div>

            <div class="d-flex flex-row justify-content-between">
                <span class="fs-6 fw-bold">Total</span>
                <span class="fs-6 fw-bold" id="total">Rp. <?php echo e(number_format($subTotal, 0, ',', '.')); ?></span>
            </div>

            <!-- ✅ Tombol Checkout -->
            <div class="pt-4 w-100">
                <button type="submit" class="w-100 btn py-2 text-white bg-main3"
                    style="border-radius: 50px;">
                    Checkout
                </button>
            </div>
        </div>
    </form>
</section>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
<script>
    function formatRupiah(angka) {
        return 'Rp' + angka.toLocaleString('id-ID');
    }

    function updateTotal() {
        let subtotal = 0;

        document.querySelectorAll('.order-card').forEach(card => {
            let price = parseInt(card.dataset.price);
            let topping = parseInt(card.dataset.topping);
            let key = card.dataset.key;
            let qty = parseInt(document.getElementById('qty-input-' + key).value);
            let itemTotal = (price + topping) * qty;

            document.getElementById('item-total-' + key).textContent = formatRupiah(itemTotal);
            subtotal += itemTotal;
        });

        document.getElementById('subtotal').textContent = formatRupiah(subtotal);
        document.getElementById('total').textContent = formatRupiah(subtotal);
    }

    // ✅ Event listener qty dengan AJAX
    document.querySelectorAll('.qty-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            let key = this.dataset.key;
            let change = parseInt(this.dataset.change);

            let qtyDisplay = document.getElementById('qty-display-' + key);
            let qtyInput = document.getElementById('qty-input-' + key);

            let newQty = Math.max(1, parseInt(qtyInput.value) + change);

            // ✅ Update DOM sementara (UX lebih responsif)
            qtyDisplay.textContent = newQty;
            qtyInput.value = newQty;

            // ✅ Kirim AJAX ke backend
            fetch('<?php echo e(route('order.updateQty')); ?>', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
                        },
                        body: JSON.stringify({
                            key: key,
                            quantity: newQty
                        })
                    })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        updateTotal(); // ✅ Re-hit total
                    } else {
                        alert('Gagal update qty!');
                    }
                })
                .catch(err => console.error(err));
        });
    });

    // ✅ Event listener tombol hapus
    document.querySelectorAll('.delete-item').forEach(button => {
        button.addEventListener('click', function() {
            const key = this.dataset.key;

            // Hapus elemen item dari DOM
            const itemCard = document.querySelector(`.order-card[data-key="${key}"]`);
            const inputElements = document.querySelectorAll(`input[name^="order_items[${key}]"]`);

            if (itemCard) itemCard.remove();
            inputElements.forEach(input => input.remove());

            // Update total
            updateTotal();

            // (Opsional) Kirim ke backend untuk hapus dari session
            fetch('<?php echo e(route('order.removeItem')); ?>', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
                        },
                        body: JSON.stringify({
                            key: key
                        })
                    }).then(response => response.json())
                .then(data => {
                    if (!data.success) {
                        alert('Gagal menghapus item dari sesi!');
                    }
                }).catch(console.error);
        });
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\warkop-main\resources\views/pages/product/checkout.blade.php ENDPATH**/ ?>