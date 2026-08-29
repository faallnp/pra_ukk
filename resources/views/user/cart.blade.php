@extends('user.layout.app')

@section('title', 'Keranjang')

@section('content')

<div class="container py-5">

    <div class="mb-4">
        <span class="text-danger"><i class="bi bi-bag"></i> Keranjang Belanja</span>
        <h2>Keranjang Saya</h2>
        <p class="text-muted">Periksa kembali produk yang ingin kamu beli.</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(count($cart) > 0)

        @php
            $total = 0;
        @endphp

        <div class="row g-4">

            <!-- Kolom Kiri: Item Cart -->
            <div class="col-lg-7">

                @foreach($cart as $item)

                    @php
                        $subtotal = $item['price'] * $item['qty'];
                        $total += $subtotal;
                    @endphp

                    <div class="card shadow-sm mb-3">

                        <div class="card-body">

                            <div class="row align-items-center">

                                <div class="col-md-2 text-center">

                                    <img
                                        src="{{ $item['image'] ? asset('uploads/menu/'.$item['image']) : asset('images/gudeg.png') }}"
                                        class="img-fluid rounded"
                                        style="height:100px; object-fit:cover;">

                                </div>

                                <div class="col-md-5">

                                    <h6 class="mb-2">{{ $item['name'] }}</h6>

                                    <p class="mb-1" style="color: #8B4513;">
                                        <strong>Rp {{ number_format($item['price'],0,',','.') }}</strong>
                                    </p>

                                    <span class="badge bg-success">Tersedia</span>

                                </div>

                                <div class="col-md-3">

                                    <div class="d-flex justify-content-center align-items-center gap-2">

                                        <form
                                            action="{{ route('cart.update', $item['id']) }}"
                                            method="POST"
                                            style="display:inline;">

                                            @csrf

                                            <input type="hidden" name="action" value="minus">

                                            <button class="btn btn-sm btn-outline-secondary" type="submit">
                                                −
                                            </button>

                                        </form>

                                        <span class="fw-bold" style="min-width:30px; text-align:center;">
                                            {{ $item['qty'] }}
                                        </span>

                                        <form
                                            action="{{ route('cart.update', $item['id']) }}"
                                            method="POST"
                                            style="display:inline;">

                                            @csrf

                                            <input type="hidden" name="action" value="plus">

                                            <button class="btn btn-sm btn-outline-secondary" type="submit">
                                                +
                                            </button>

                                        </form>

                                    </div>

                                </div>

                                <div class="col-md-2 text-end">

                                    <div class="mb-2">
                                        <p class="text-muted small mb-1">Subtotal</p>
                                        <strong style="color: #8B4513;">Rp {{ number_format($subtotal,0,',','.') }}</strong>
                                    </div>

                                    <form
                                        action="{{ route('cart.remove', $item['id']) }}"
                                        method="POST"
                                        style="display:inline;">

                                        @csrf

                                        <button class="btn btn-danger btn-sm" type="submit">
                                            <i class="bi bi-trash"></i> Hapus
                                        </button>

                                    </form>

                                </div>

                            </div>

                        </div>

                    </div>

                @endforeach

                <div class="mt-3">
                    <a href="{{ route('menu') }}" class="btn" style="color: #8B4513; border: 1px solid #8B4513;">
                        <i class="bi bi-chevron-left"></i> Lanjut Belanja
                    </a>
                </div>

            </div>

            <!-- Kolom Kanan: Ringkasan Belanja -->
            <div class="col-lg-5">

                <div class="card shadow-sm">

                    <div class="card-body">

                        <h5 class="mb-4">Ringkasan Belanja</h5>

                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-2">
                                <span>Total Barang ({{ count($cart) }})</span>
                                <span>Rp {{ number_format($total,0,',','.') }}</span>
                            </div>
                        </div>

                        <hr>

                        <div class="mb-4">
                            <div class="d-flex justify-content-between">
                                <h6 class="mb-0">Total Harga</h6>
                                <h6 class="mb-0" style="color: #8B4513;">Rp {{ number_format($total,0,',','.') }}</h6>
                            </div>
                        </div>

                        <a
                            href="{{ route('checkout.index') }}"
                            class="btn w-100 mb-2"  
                            style="background-color: #8B4513; color: white;">

                            Checkout Sekarang <i class="bi bi-arrow-right"></i>

                        </a>

                    </div>

                </div>

            </div>

        </div>

    @else

        <div class="alert alert-warning text-center py-5">

            <h5 class="mb-3">Keranjang masih kosong</h5>

            <p class="mb-4">Silakan pilih menu terlebih dahulu.</p>

            <a
                href="{{ route('menu') }}"
                class="btn w-100"
                style="background-color: #8B4513; color: white;">

                <i class="bi bi-bag-check"></i> Belanja Sekarang

            </a>

        </div>

    @endif

</div>

@endsection