<title>Warkop Boengsoe</title>



<?php $__env->startSection('content'); ?>

<form action="<?php echo e(route('guest.add')); ?>" method="POST">
    <?php echo csrf_field(); ?>
    <section class="container flex d-flex flex-column align-items-center justify-content-center gap-4 py-4 px-3">
        <img src="<?php echo e(asset('assets/images/logo.webp')); ?>" alt="logo" class="w-25">
        <div class="w-100 rounded px-2 py-4 d-flex flex-column text-center" style="background-color: #535353;">
            <div class="mx-auto">
                <h2 class="text-center text-sm text-white">Selamat Datang</h2>
                <p class="text-white" style="font-size: 16px; font-weight: 100">Silakan masukan data diri anda untuk melakukan pemesanan</p>
            </div>
            <?php echo csrf_field(); ?>
            <div class="py-2 d-flex flex-column text-start">
                <label for="name" class="text-white">Nama</label>
                <input type="text" name="name" id="name" class="py-2 rounded border-none px-2" placeholder="Masukan nama anda" required>
            </div>
            <div class="py-2 mb-4 d-flex flex-column text-start">
                <label for="table_number" class="text-white">Nomor Meja</label>
                <input type="text" name="table_number" id="table_number" class="py-2 rounded border-none px-2" placeholder="Masukan nomor meja anda" required>
            </div>
            <button type="submit" class="py-2 mt-4 text-white rounded btn bg-main">
                <span>Simpan</span>
            </button>
            <p class="text-white mt-4" style="font-size: 12px; font-weight: 100">Pastikan nama dan nomor meja tidak salah ya</p>
            <p class="text-white mt-4" style="font-size: 12px; font-weight: 100">App Version 1.0</p>
        </div>
    </section>
</form>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\warkop-main\resources\views/welcome.blade.php ENDPATH**/ ?>