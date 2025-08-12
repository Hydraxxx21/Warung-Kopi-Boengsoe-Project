<!-- Sidebar -->
<div class="sidebar d-flex flex-column justify-between">
    <div class="nav flex-column">
        <a href="<?php echo e(route('dashboard')); ?>" class="sidebar-link active">
            <i class="fas fa-home"></i> Dashboard
        </a>
        <a href="<?php echo e(route('pemesanan.index')); ?>" class="sidebar-link active">
            <i class="fa-solid fa-cart-shopping"></i> Pemesanan
        </a>
        <a href="<?php echo e(route('topping.index')); ?>" class="sidebar-link active">
            <i class="fa-solid fa-comments-dollar"></i> Topping
        </a>
        <a href="<?php echo e(route('inventory.index')); ?>" class="sidebar-link active">
            <i class="fa-solid fa-warehouse"></i> Inventory
        </a>
        <a href="<?php echo e(route('user.index')); ?>" class="sidebar-link active">
            <i class="fa-solid fa-users"></i> User
        </a>
        <form action="<?php echo e(route('logout')); ?>" method="POST">
            <?php echo csrf_field(); ?>

            <button type="submit" class="sidebar-link text-start w-100">
                <i class="fa-solid fa-right-from-bracket"></i> Logout
            </button>

        </form>
    </div>
</div><?php /**PATH C:\xampp\htdocs\warkop-main\resources\views/layouts/sidebar-admin.blade.php ENDPATH**/ ?>