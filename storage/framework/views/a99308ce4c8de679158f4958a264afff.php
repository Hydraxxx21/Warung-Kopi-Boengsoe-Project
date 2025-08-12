<?php echo $__env->make('layouts.navbar-admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('layouts.sidebar-admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<div class="main-content mt-5">
    <div class="container-fluid">
        <div class="card">
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

            <div class="card-header">
                <span class="font-bold">Produk</span>
            </div>
            <div class="card-body">
                <form action="<?php echo e(route('inventory.store')); ?>" method="POST" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('POST'); ?>

                    <div class="d-flex flex-column gap-3">

                        <div class="form-group">
                            <label for="name">Nama Produk</label>
                            <input type="text" name="name" id="name" placeholder="masukkan nama produk..." value="<?php echo e(old('name')); ?>" class="form-control ">
                        </div>

                        <div class="form-group">
                            <label for="image">Gambar Produk</label>
                            <input type="file" name="imageUrl" id="imageUrl" value="<?php echo e(old('imageUrl')); ?>" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="price">Harga Produk</label>
                            <input type="number" name="price" id="price" placeholder="masukkan harga produk..." value="<?php echo e(old('price')); ?>" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="description">Deskripsi Produk</label>
                            <input type="text" name="description" id="description" placeholder="masukkan deskripsi produk..." value="<?php echo e(old('description')); ?>" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="topping_ids">Topping Produk</label>
                            <select name="topping_ids[]" id="topping_ids" class="form-control" multiple>
                                <?php $__currentLoopData = $toppings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $topping): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($topping->id); ?>"><?php echo e($topping->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="category">Kategori Produk</label>
                            <select name="category" id="category" class="form-control">
                                <option value="makanan">Makanan</option>
                                <option value="softdrink">Softdrink</option>
                                <option value="snack">Snack</option>
                                <option value="kopi">Kopi</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="is_available">Status Produk</label>
                            <select name="is_available" id="is_available" class="form-control">
                                <option value="1">Tersedia</option>
                                <option value="0">Tidak Tersedia</option>
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-secondary mt-4">Tambah Produk</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php echo $__env->make('layouts.header-admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\warkop-main\resources\views/admin/inventory/create.blade.php ENDPATH**/ ?>