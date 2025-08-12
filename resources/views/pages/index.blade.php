<title>Home Boengsoe</title>
@extends('layouts.app')
@section('content')

@if (session()->has('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

@if (session()->has('error'))
<div class="alert alert-danger">
    {{ session('error') }}
</div>
@endif

<section class="container flex d-flex flex-column gap-4 py-4 px-2">
    <span class="d-flex text-center" style="letter-spacing: 4px;">JANGAN LUPA MAKAN, SEMOGA HARI MU HAHA HIHI</span>

    <div class="p-3 rounded" style="border: 2px solid ; border-color: #000;">
        <span class="d-flex text-start fw-bold text-capitalize">Pilih menu</span>
    </div>

    <div class="scroll-x-hidden rounded" style="border: 2px solid #000;">
        <div class="p-3 d-flex flex-row justify-content-between" style="min-width: max-content;">
            <!-- Makanan Category -->
            <div class="category-item d-flex flex-column text-center align-items-center justify-content-center me-3 text-decoration-none text-dark p-2 rounded cursor-pointer {{ $category == 'makanan' ? 'active' : '' }}"
                data-category="makanan"
                onclick="toggleCategory('makanan')">
                <img src="{{ asset('assets/images/bibimbap.webp') }}" alt="food" style="width: 60px;">
                <span class="fs-6">Makanan</span>
            </div>

            <!-- Minuman Category -->
            <div class="category-item d-flex flex-column text-center align-items-center justify-content-center me-3 text-decoration-none text-dark p-2 rounded cursor-pointer {{ $category == 'softdrink' ? 'active' : '' }}"
                data-category="softdrink"
                onclick="toggleCategory('softdrink')">
                <img src="{{ asset('assets/images/drink.webp') }}" alt="drink" style="width: 60px;">
                <span class="fs-6">Minuman</span>
            </div>

            <!-- Kopi Category -->
            <div class="category-item d-flex flex-column text-center align-items-center justify-content-center me-3 text-decoration-none text-dark p-2 rounded cursor-pointer {{ $category == 'kopi' ? 'active' : '' }}"
                data-category="kopi"
                onclick="toggleCategory('kopi')">
                <img src="{{ asset('assets/images/coffee-cup.webp') }}" alt="coffee" style="width: 60px;">
                <span class="fs-6">Kopi</span>
            </div>

            <!-- Snack Category -->
            <div class="category-item d-flex flex-column text-center align-items-center justify-content-center text-decoration-none text-dark p-2 rounded cursor-pointer {{ $category == 'snack' ? 'active' : '' }}"
                data-category="snack"
                onclick="toggleCategory('snack')">
                <img src="{{ asset('assets/images/snack.webp') }}" alt="snack" style="width: 60px;">
                <span class="fs-6">Snack</span>
            </div>
        </div>
    </div>

    <div class="d-flex flex-column gap-2 overflow-scroll" style="max-height: relative;">
        @foreach($products as $product)
        <div class="d-flex flex-row rounded overflow-hidden mb-4" style="height: 200px; border: 2px solid ; border-color: #000;">
            <img src="{{ Storage::url($product->imageUrl) }}" alt="{{ $product->name }}" style="width: 35%; height: 100%; object-fit: cover; border: 2px solid #000; border-top-right-radius: 12px; border-bottom-right-radius: 12px;">
            <div class=" p-3 d-flex flex-column justify-content-between gap-1 flex-grow-1">
                <div class="d-flex flex-column gap-1">
                    <span class="fs-6 fw-bold">{{ $product->name }}</span>
                    <span class="fw-lighter" style="font-size: 14px;">
                        {{ $product->description }}
                    </span>
                    <span class="fw-bold">Rp. {{ number_format($product->price, 0, ',', '.') }}</span>
                </div>
                <a href="{{ route('products.index', $product->id) }}" class="py-2 text-white rounded btn bg-main2" style="font-size: 10px;">Tambah</a>
            </div>
        </div>
        @endforeach

        @if($products->isEmpty())
        <div class="d-flex flex-column align-items-center justify-content-center" style="height: 200px;">
            <span class="fw-bold text-capitalize">
                {{ $category ? ucfirst($category) . ' tidak ada' : 'Tidak ada data' }}
            </span>
        </div>
        @endif
    </div>

    @if($countOrder > 0)
    <div class="fixed-bottom d-flex justify-content-center align-items-center p-3">
        <a href="{{ route('products.checkout') }}"
            class="btn btn-secondary text-white d-flex flex-row rounded align-items-center justify-content-between w-100" style="max-width: 512px;">
            <div class="d-flex flex-column justify-content-start text-start gap-1">
                <span class="fw-semibold">
                    {{ $countOrder }} Item
                </span>
                <span class="fw-lighter" style="font-size: 10px;">
                    Cek Kembali Pesanan
                </span>
            </div>
            <span>
                Rp.{{ number_format($totalHarga, 0, ',', '.') }}
            </span>
        </a>
    </div>
    @endif
</section>

<script>
    let activeCategory = '{{ $category ?? "" }}'; // Get current category from Laravel

    function toggleCategory(category) {
        // Jika kategori yang sama diklik lagi, clear filter
        if (activeCategory === category) {
            // Redirect ke halaman tanpa parameter category (clear filter)
            window.location.href = '{{ route("dashboard.index") }}';
            return;
        }

        // Redirect ke halaman dengan category parameter
        window.location.href = '{{ route("dashboard.index") }}?category=' + category;
    }

    function getCategoryDisplayName(category) {
        const displayNames = {
            'makanan': 'Makanan',
            'softdrink': 'Minuman',
            'kopi': 'Kopi',
            'snack': 'Snack'
        };
        return displayNames[category] || category;
    }
    x
</script>

@endsection