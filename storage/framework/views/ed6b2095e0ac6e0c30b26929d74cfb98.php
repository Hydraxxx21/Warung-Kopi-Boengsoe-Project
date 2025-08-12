<?php echo $__env->make('layouts.navbar-admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('layouts.sidebar-admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<div class="main-content mt-5">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
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

                <span class="font-bold">Users</span>
            </div>
            <div class="card-body d-flex flex-column gap-2">
                <form class="d-flex flex-column" action="<?php echo e(route('user.update', $user->id)); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>

                    <div class="d-flex flex-column">
                        <label for="name">Nama</label>
                        <input type="text" name="name" id="name" class="py-1 rounded border-none px-2" placeholder="masukkan nama..." style="font-size: 12px;" value="<?php echo e($user->name); ?>">
                    </div>

                    <div class="d-flex flex-column">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" class="py-1 rounded border-none px-2" placeholder="masukkan email..." style="font-size: 12px;" value="<?php echo e($user->email); ?>">
                    </div>

                    <div class="d-flex flex-column">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" class="py-1 rounded border-none px-2" placeholder="masukkan password..." style="font-size: 12px;">
                    </div>

                    <div class="d-flex flex-column">
                        <label for="role">Role</label>
                        <select name="role" id="role" class="py-1 rounded border-none px-2" style="font-size: 12px;" value="<?php echo e($user->role); ?>">
                            <option value="1" <?php echo e($user->role == 1 ? 'selected' : ''); ?>>Admin</option>
                            <option value="2" <?php echo e($user->role == 2 ? 'selected' : ''); ?>>Kasir</option>
                        </select>
                    </div>

                    <div class="d-flex flex-column mt-4">
                        <button class="btn py-2 text-white" style="background-color: #535353; border-radius: 50px;">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php echo $__env->make('layouts.header-admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\warkop-main\resources\views/admin/user/edit.blade.php ENDPATH**/ ?>