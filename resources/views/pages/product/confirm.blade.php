@extends('layouts.app')

@section('content')

<div class="d-flex flex-column gap-4 p-4">
    @if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif

    <div class="position-relative">
        <!-- 🔙 Tombol Back -->
        <div class="position-absolute top-0 start-0 m-3 p-2 d-flex align-items-center justify-content-center"
            onclick="window.history.back();"
            style="background-color: #535353; border-radius: 50%; cursor: pointer; width: 36px; height: 36px;">
            <img src="{{ asset('assets/images/icon-back.webp') }}" alt="Back" style="width: 16px;">
        </div>
        <span class=" text-center d-flex flex-column mt-3">Apakah kamu yakin?</span>
    </div>


    <div class="d-flex flex-column gap-4 py-4 px-3 rounded" style="background-color: #D9D9D9;">
        <div class="d-flex flex-column gap-1">
            <span class="fw-bold fs-6 text-uppercase">nomor meja {{ $guest['table_number'] ?? '-' }}</span>
            <span class="fw-light" style="font-size: 16px;">{{ $guest['name'] ?? '-' }}</span>
        </div>
        <div class="d-flex flex-column gap-2 py-4" style="border-bottom: 2px solid #000;">

            @php $totalOrder = 0; @endphp

            @foreach($order['items'] as $orderItem)
            @php
            // Hitung harga dasar produk
            $productSubtotal = $orderItem['quantity'] * $orderItem['price'];

            // Hitung total harga toppings
            $toppingsTotal = 0;
            $toppings = $orderItem['toppings'] ?? [];

            // Jika toppings masih JSON string, decode dulu
            if (is_string($toppings)) {
            $toppings = json_decode($toppings, true);
            if (!is_array($toppings)) {
            $toppings = [];
            }
            }

            if (!empty($toppings)) {
            foreach ($toppings as $topping) {
            $toppingsTotal += floatval($topping['price'] ?? 0);
            }
            }

            // Total toppings dikalikan dengan quantity
            $toppingsSubtotal = $toppingsTotal * $orderItem['quantity'];

            // Subtotal keseluruhan per item = (harga produk + harga toppings) * quantity
            $itemSubtotal = $productSubtotal + $toppingsSubtotal;

            // Tambahkan ke total keseluruhan
            $totalOrder += $itemSubtotal;
            @endphp

            <div class="d-flex flex-row justify-content-between">
                <div class="d-flex flex-column gap-1">
                    <span class="fs-6 fw-bold">{{ $orderItem['name'] ?? 'Product Name' }}</span>
                    <span style="font-size: 12px;">Qty: {{ $orderItem['quantity'] ?? '-' }}</span>
                    <span style="font-size: 12px;">
                        Topping:
                        @if(!empty($toppings))
                        @foreach($toppings as $topping)
                        {{ $topping['name'] ?? 'Unknown' }}@if(!$loop->last), @endif
                        @endforeach
                        @else
                        -
                        @endif
                    </span>
                    <span style="font-size: 12px;">Catatan: {{ $orderItem['note'] ?? '-' }}</span>

                    {{-- Detail perhitungan (opsional, bisa dihapus jika tidak perlu) --}}
                    <div style="font-size: 10px; color: #666;">
                        <div>Harga produk: Rp. {{ number_format($orderItem['price'], 0, ',', '.') }} x {{ $orderItem['quantity'] }}</div>
                        @if($toppingsTotal > 0)
                        <div>Harga topping: Rp. {{ number_format($toppingsTotal, 0, ',', '.') }} x {{ $orderItem['quantity'] }}</div>
                        @endif
                    </div>
                </div>
                <span class="fw-bold">Rp. {{ number_format($itemSubtotal, 0, ',', '.') }}</span>
            </div>
            @endforeach

            <div class="d-flex flex-row justify-content-between">
                <span class="fw-bold">Total</span>
                <span class="fw-bold">Rp. {{ number_format($totalOrder, 0, ',', '.') }}</span>
            </div>
        </div>
        <div class="py-2 w-100">
            <form action="{{ route('order.storeOrder') }}" method="POST">
                @csrf
                <button type="submit" class="w-100 btn py-2 text-white bg-main" style="border-radius: 50px;">
                    Kirim Pesanan
                </button>
            </form>
        </div>
    </div>
</div>
@endsection