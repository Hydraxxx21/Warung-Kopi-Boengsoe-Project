<?php echo $__env->make('layouts.navbar-admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('layouts.sidebar-admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<div class="main-content mt-5">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <span class="font-bold">Produk</span>
            </div>
            <div class="card-body ">
                <button>
                    <a class="btn btn-sm btn-secondary" href="<?php echo e(route('inventory.create')); ?>">Tambah Produk</a>
                </button>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Nama Produk</th>
                            <th scope="col">Foto</th>
                            <th scope="col">Harga</th>
                            <th scope="col">Kategori</th>
                            <th scope="col">Topping</th>
                            <th scope="col">Ready?</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td scope="row"><?php echo e($loop->iteration); ?></td>
                            <td><?php echo e($product->name); ?></td>
                            <td>
                                <?php if($product->imageUrl): ?>
                                <img src="<?php echo e(asset('storage/' . $product->imageUrl)); ?>" alt="Product Image" width="100">
                                <?php else: ?>
                                No Image
                                <?php endif; ?>
                            </td>
                            <td>Rp. <?php echo e(number_format($product->price, 0, ',', '.')); ?></td>
                            <td><?php echo e($product->category); ?></td>
                            <td><span class="badge bg-secondary text-white"><?php echo e($product->toppings()->pluck('name')->implode(', ')); ?></span></td>
                            <td>
                                <?php if($product->is_available): ?>
                                <span class="text-success">Ready</span>
                                <?php else: ?>
                                <span class="text-danger">Not Ready</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="<?php echo e(route('inventory.edit', $product->id)); ?>" class="btn btn-sm btn-warning text-white d-inline-block">
                                    Edit
                                </a>
                                <div class="d-inline-block">
                                    <form action="<?php echo e(route('inventory.destroy', $product->id)); ?>" method="POST">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-sm btn-danger text-white">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <!--  -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php echo $__env->make('layouts.header-admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\warkop-main\resources\views/admin/inventory/index.blade.php ENDPATH**/ ?>