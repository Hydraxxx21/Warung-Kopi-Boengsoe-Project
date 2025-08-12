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
                <span class="font-bold">Topping</span>
            </div>
            <div class="card-body">
                <form action="<?php echo e(route('topping.update', $topping->id)); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>

                    <div class="d-flex flex-column gap-3">

                        <div class="form-group">
                            <label for="name">Nama Topping</label>
                            <input type="text" name="name" id="name" placeholder="masukkan nama topping..." class="form-control" value="<?php echo e($topping->name); ?>">
                        </div>

                        <div class="form-group">
                            <label for="price">Harga Topping</label>
                            <input type="number" name="price" id="price" placeholder="masukkan harga topping..." class="form-control" value="<?php echo e($topping->price); ?>">
                        </div>

                        <div class="form-group">
                            <label for="is_available">Status Topping</label>
                            <select name="is_available" id="is_available" class="form-control" value="<?php echo e($topping->is_available); ?>">
                                <option value="1" <?php echo e($topping->is_available == 1 ? 'selected' : ''); ?>>Tersedia</option>
                                <option value="0" <?php echo e($topping->is_available == 0 ? 'selected' : ''); ?>>Tidak Tersedia</option>
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-secondary mt-4">Tambah Topping</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php echo $__env->make('layouts.header-admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\warkop-main\resources\views/admin/topping/edit.blade.php ENDPATH**/ ?>