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
    <div class="container-fluid">
        <div class="row gap-2 justify-content-center">
            <div class="mb-4 mx-3 col-md-3 d-flex flex-column align-items-center justify-content-center py-4 gap-2 text-white card shadow-md" style="background-color: #949494;">
                <span class="fs-5">Orderan Pending</span>
                <div class="d-flex flex-row align-items-center justify-content-center gap-2 fs-4">
                    <i class="fa-solid fa-hourglass-half"></i>
                    <span><?php echo e($dataPendingCount); ?></span>
                </div>
            </div>
            <div class="mb-4 mx-3 col-md-3 d-flex flex-column align-items-center justify-content-center py-4 gap-2 text-white card shadow-md" style="background-color: #949494;">
                <span class="fs-5">Orderan Selesai</span>
                <div class="d-flex flex-row align-items-center justify-content-center gap-2 fs-4">
                    <i class="fa-solid fa-clipboard-check"></i>
                    <span><?php echo e($dataCompletedCount); ?></span>
                </div>
            </div>
            <div class="mb-4 mx-3 col-md-3 d-flex flex-column align-items-center justify-content-center py-4 gap-2 text-white card shadow-md" style="background-color: #949494;">
                <span class="fs-5">Total Transaksi</span>
                <div class="d-flex flex-row align-items-center justify-content-center gap-2 fs-4">
                    <i class="fa-solid fa-money-check-dollar"></i>
                    <span>Rp.<?php echo e(number_format($totalPrice)); ?></span>
                </div>
            </div>
            <div class="mb-4 mx-3 col-md-3 d-flex flex-column align-items-center justify-content-center py-4 gap-2 text-white card shadow-md" style="background-color: #949494;">
                <span class="fs-5">Transaksi Cash</span>
                <div class="d-flex flex-row align-items-center justify-content-center gap-2 fs-4">
                    <i class="fa-solid fa-money-check-dollar"></i>
                    <span>Rp.<?php echo e(number_format($totalFromCash)); ?></span>
                </div>
            </div>
            <div class="mb-4 mx-3 col-md-3 d-flex flex-column align-items-center justify-content-center py-4 gap-2 text-white card shadow-md" style="background-color: #949494;">
                <span class="fs-5">Transaksi QRIS</span>
                <div class="d-flex flex-row align-items-center justify-content-center gap-2 fs-4">
                    <i class="fa-solid fa-money-check-dollar"></i>
                    <span>Rp.<?php echo e(number_format($totalFromQris)); ?></span>
                </div>
            </div>
        </div>

        <div class="py-3 px-2 fs-5 text-center border border-dark rounded-top" style="background-color: #D9D9D9;">
            <span class="font-bold">Transaksi</span>
        </div>

        <form action="<?php echo e(route('pemesanan.index')); ?>" action="GET" class="d-flex flex-row gap-2 align-items-center justify-content-between p-3 border border-dark" style="background-color: #D9D9D9; margin-bottom:0">
            <?php echo csrf_field(); ?>
            <input type="text" name="search" class="form-control w-50" placeholder="Cari pesanan" value="<?php echo e(request('search')); ?>">
            <select name="sort_by" class="form-control w-25">
                <option value="id" <?php echo e(($filters['sort_by'] ?? '') === 'id' ? 'selected' : ''); ?>>ID</option>
                <option value="name" <?php echo e(($filters['sort_by'] ?? '') === 'name' ? 'selected' : ''); ?>>Nama</option>
                <option value="table_number" <?php echo e(($filters['sort_by'] ?? '') === 'table_number' ? 'selected' : ''); ?>>Nomor Meja</option>
            </select>
            <select name="order" class="form-control w-25">
                <option value="asc" <?php echo e(($filters['order'] ?? '') === 'asc' ? 'selected' : ''); ?>>Asc</option>
                <option value="desc" <?php echo e(($filters['order'] ?? '') === 'desc' ? 'selected' : ''); ?>>Desc</option>
            </select>
            <button type="submit" class="btn bg-secondary text-white">Cari</button>
        </form>

        <table class="table table-bordered border-dark align-middle">
            <thead>
                <tr class="text-center">
                    <th class="border-end">ID</th>
                    <th class="border-start border-end">Nama</th>
                    <th class="border-start border-end">No Meja</th>
                    <th class="border-start border-end">Pesanan</th>
                    <th class="border-start border-end">Total</th>
                    <th class="border-start border-end">Status</th>
                    <th class="border-start border-end">Metode Pembayaran</th>
                    <th class="border-start">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr class="text-center">
                    <th scope="row">#<?php echo e($d->id); ?></th>
                    <td><?php echo e($d->name); ?></td>
                    <td data-bs-toggle="modal" data-bs-target="#updateModalTableNumber<?php echo e($d->id); ?>" class="cursor-pointer"><?php echo e($d->table_number); ?></td>
                    <td class="text-start">
                        <ul class="d-flex flex-column gap-2">
                            <?php $__currentLoopData = $d->orderItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li>
                                - <?php echo e($item->product->name ?? '-'); ?> (<?php echo e($item->quantity); ?>)
                                <ul style="font-size: 12px;">
                                    <li>Topping:
                                        <?php echo e($item->toppings->pluck('name')->implode(', ') ?: '-'); ?>

                                    </li>
                                    <li>Catatan: <?php echo e($item->notes ?? '-'); ?></li>
                                </ul>
                            </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </td>
                    <td>Rp.<?php echo e(number_format($d->total_price)); ?></td>
                    <td>
                        <div data-bs-toggle="modal" data-bs-target="#updateStatusModal<?php echo e($d->id); ?>"
                            class="text-capitalize cursor-pointer badge 
                        <?php if($d->status == 'pending'): ?> bg-warning 
                        <?php elseif($d->status == 'completed'): ?> bg-info 
                        <?php else: ?> bg-danger <?php endif; ?>">
                            <?php echo e($d->status); ?>

                        </div>
                    </td>
                    <td>
                        <div data-bs-toggle="modal" data-bs-target="#updateStatusPayment<?php echo e($d->id); ?>" class="text-capitalize cursor-pointer badge 
                        <?php if($d->payment_method == 'cash'): ?> bg-success 
                        <?php elseif($d->payment_method == 'qris'): ?> bg-danger 
                        <?php endif; ?>">
                            <?php echo e($d->payment_method); ?>

                        </div>
                    </td>
                    <td>
                        <button>
                            <a href="<?php echo e(route('pemesanan.detail', $d->id)); ?>" class="badge bg-secondary text-white text-decoration-none">Lihat detail</a>
                        </button>
                    </td>
                </tr>

                <!-- Modal Status -->
                <div class="modal fade mt-10" id="updateStatusModal<?php echo e($d->id); ?>" tabindex="-1"
                    aria-labelledby="updateStatusModalLabel<?php echo e($d->id); ?>" aria-hidden="true">
                    <div class="modal-dialog">
                        <form action="<?php echo e(route('pemesanan.updateStatus', $d->id)); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('PUT'); ?>
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="updateStatusModalLabel<?php echo e($d->id); ?>">
                                        Ubah Status - #<?php echo e($d->id); ?> - <?php echo e($d->name); ?>

                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Tutup"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="status-<?php echo e($d->id); ?>">Pilih Status</label>
                                        <select name="status" id="status-<?php echo e($d->id); ?>" class="form-control" required>
                                            <option value="pending" <?php echo e($d->status == 'pending' ? 'selected' : ''); ?>>Pending</option>
                                            <option value="completed" <?php echo e($d->status == 'completed' ? 'selected' : ''); ?>>Terima</option>
                                            <option value="cancelled" <?php echo e($d->status == 'cancelled' ? 'selected' : ''); ?>>Tolak</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Modal Payment -->
                <div class="modal fade mt-10" id="updateStatusPayment<?php echo e($d->id); ?>" tabindex="-1"
                    aria-labelledby="updateStatusPaymentLabel<?php echo e($d->id); ?>" aria-hidden="true">
                    <div class="modal-dialog">
                        <form action="<?php echo e(route('pemesanan.updatePayment', $d->id)); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('PUT'); ?>
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="updateStatusPaymentLabel<?php echo e($d->id); ?>">
                                        Ubah Payment Method - #<?php echo e($d->id); ?> - <?php echo e($d->name); ?>

                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Tutup"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="payment_method-<?php echo e($d->id); ?>">Pilih Method</label>
                                        <select name="payment_method" id="payment_method-<?php echo e($d->id); ?>" class="form-control" required>
                                            <option value="cash" <?php echo e($d->payment_method == 'cash' ? 'selected' : ''); ?>>Cash</option>
                                            <option value="qris" <?php echo e($d->payment_method == 'qris' ? 'selected' : ''); ?>>Qris</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Modal Table Number -->
                <div class="modal fade mt-10" id="updateModalTableNumber<?php echo e($d->id); ?>" tabindex="-1"
                    aria-labelledby="updateModalTableNumberLabel<?php echo e($d->id); ?>" aria-hidden="true">
                    <div class="modal-dialog">
                        <form action="<?php echo e(route('pemesanan.updateTableNumber', $d->id)); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('PUT'); ?>
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="updateModalTableNumberLabel<?php echo e($d->id); ?>">
                                        Ubah Nomor Meja - #<?php echo e($d->id); ?> - <?php echo e($d->name); ?>

                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Tutup"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="table_number-<?php echo e($d->id); ?>">Nomor Meja</label>
                                        <input type="number" name="table_number" id="table_number-<?php echo e($d->id); ?>" class="form-control" required />
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>


    </div>
</div>
<?php echo $__env->make('layouts.header-admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\warkop-main\resources\views/admin/pemesanan/index.blade.php ENDPATH**/ ?>