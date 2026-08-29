@extends('user.layout.app')

@section('title', 'Checkout')

@section('content')

<div class="container-fluid py-5">

    <h2 class="mb-4 ps-3" style="color: #4B2E2E;">Orderan Kamu</h2>

    @if(count($cart) == 0)

        <div class="row px-3">

            <div class="col-lg-7">

                <div class="alert alert-warning text-center py-5">

                    <h5 class="mb-3">Keranjang masih kosong</h5>

                    <p class="mb-4">Silakan pilih menu terlebih dahulu.</p>

                    <a href="{{ route('menu') }}" class="btn w-100" style="background-color: #8B4513; color: white;">
                        <i class="bi bi-bag-check"></i> Belanja Sekarang
                    </a>

                </div>

            </div>

        </div>

    @else

        <div class="row g-4 px-3">

            <!-- Kolom Kiri: Cart Items -->
            <div class="col-lg-7">

                <h5 class="mb-3">
                    <i class="bi bi-bag-check"></i> Keranjang ({{ count($cart) }})
                </h5>

                @foreach($cart as $item)

                    @php
                        $subtotal = $item['price'] * $item['qty'];
                    @endphp

                    <div class="card shadow-sm mb-3">

                        <div class="card-body">

                            <div class="row align-items-center g-2">

                                <div class="col-3 text-center">

                                    <img
                                        src="{{ $item['image'] ? asset('uploads/menu/'.$item['image']) : asset('images/gudeg.png') }}"
                                        class="img-fluid rounded"
                                        style="height:80px; object-fit:cover;">

                                </div>

                                <div class="col-4">

                                    <h6 class="mb-1">{{ $item['name'] }}</h6>

                                    <p class="text-muted mb-0 small">
                                        {{ Str::limit($item['description'] ?? 'Enak banget', 50) }}
                                    </p>

                                    <p class="mb-0 small" style="color: #8B4513;">
                                        <strong>Rp {{ number_format($item['price'],0,',','.') }}</strong>
                                    </p>

                                </div>

                                <div class="col-3">

                                    <div class="d-flex justify-content-center align-items-center gap-1">

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

                                        <span class="fw-bold" style="min-width:25px; text-align:center;">
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

                                <div class="col-2 text-end">

                                    <form
                                        action="{{ route('cart.remove', $item['id']) }}"
                                        method="POST"
                                        style="display:inline;">

                                        @csrf

                                        <button class="btn btn-sm btn-danger" type="submit">
                                            <i class="bi bi-trash"></i>
                                        </button>

                                    </form>

                                </div>

                            </div>

                            <hr class="my-2">

                            <div class="text-end">
                                <strong style="color: #8B4513;">Rp {{ number_format($subtotal,0,',','.') }}</strong>
                            </div>

                        </div>

                    </div>

                @endforeach

            </div>

            <!-- Kolom Kanan: Form Checkout -->
            <div class="col-lg-5">

                <div class="card shadow-sm">

                    <div class="card-body">

                        <h5 class="mb-4">Detail Checkout</h5>

                        <form action="{{ route('checkout.store') }}" method="POST">

                            @csrf

                            <!-- Delivery Option -->
                            <div class="mb-4">

                                <label class="form-label">Opsi Pengambilan</label>

                                <div class="row g-2">

                                    <div class="col-6">

                                        <input
                                            type="radio"
                                            id="ambil_sendiri"
                                            name="delivery_method"
                                            value="Ambil Sendiri"
                                            class="btn-check"
                                            {{ old('delivery_method') == 'Ambil Sendiri' ? 'checked' : '' }}>

                                        <label for="ambil_sendiri" class="btn btn-delivery w-100 text-center">
                                            <i class="bi bi-bag"></i><br>
                                            Ambil Sendiri
                                        </label>

                                    </div>

                                    <div class="col-6">

                                        <input
                                            type="radio"
                                            id="di_antar"
                                            name="delivery_method"
                                            value="Di Antar"
                                            class="btn-check"
                                            {{ old('delivery_method') == 'Di Antar' ? 'checked' : '' }}>

                                        <label for="di_antar" class="btn btn-delivery w-100 text-center">
                                            <i class="bi bi-truck"></i><br>
                                            Di Antar
                                        </label>

                                    </div>

                                </div>

                                @error('delivery_method')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror

                            </div>

                            <!-- Nama -->
                            <div class="mb-3">

                                <label class="form-label">Nama Lengkap</label>

                                <input
                                    type="text"
                                    name="customer_name"
                                    class="form-control @error('customer_name') is-invalid @enderror"
                                    placeholder="Namamu"
                                    value="{{ old('customer_name') ?? $user->name }}"
                                    required>

                                @error('customer_name')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror

                            </div>

                            <!-- Nomor Telepon -->
                            <div class="mb-3">

                                <label class="form-label">Nomor Telepon</label>

                                <div class="input-group">

                                    <span class="input-group-text">+62</span>

                                    <input
                                        type="text"
                                        name="phone"
                                        class="form-control @error('phone') is-invalid @enderror"
                                        placeholder="812-3456-7890"
                                        value="{{ old('phone') ?? $user->phone }}"
                                        required>

                                    @error('phone')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror

                                </div>

                            </div>

                            <!-- Alamat -->
                            <div class="mb-3">

                                <label class="form-label">Alamat Lengkap</label>

                                <textarea
                                    name="address"
                                    class="form-control @error('address') is-invalid @enderror"
                                    rows="4"
                                    placeholder="Alamat lengkap untuk pengiriman"
                                    required>{{ old('address') }}</textarea>

                                @error('address')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror

                            </div>

                            <hr>

                            <!-- Ringkasan -->
                            <div class="mb-3">

                                <div class="d-flex justify-content-between mb-2">
                                    <span>Subtotal</span>
                                    <span style="color: #8B4513;">Rp {{ number_format($total,0,',','.') }}</span>
                                </div>

                                <div class="d-flex justify-content-between mb-2">
                                    <span>Ongkos Kirim</span>
                                    <span style="color: #8B4513;" id="shippingCost">Rp 0</span>
                                </div>

                                <div class="d-flex justify-content-between fw-bold">
                                    <span>Total Harga</span>
                                    <span style="color: #8B4513;" id="totalPrice">Rp {{ number_format($total,0,',','.') }}</span>
                                </div>

                            </div>

                            <!-- Tombol Pay Now -->
                            <button type="submit" class="btn w-100" style="background-color: #8B4513; color: white;">
                                <i class="bi bi-credit-card"></i> Bayar Sekarang
                            </button>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    @endif

</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const ambilSendiri = document.getElementById('ambil_sendiri');
    const diAntar = document.getElementById('di_antar');
    const shippingCost = document.getElementById('shippingCost');
    const totalPrice = document.getElementById('totalPrice');
    const subtotal = {{ $total }};

    function updateTotal() {
        let shipping = 0;
        if (diAntar.checked) {
            shipping = 15000;
        }
        
        const total = subtotal + shipping;
        shippingCost.textContent = 'Rp ' + shipping.toLocaleString('id-ID');
        totalPrice.textContent = 'Rp ' + total.toLocaleString('id-ID');
    }

    ambilSendiri.addEventListener('change', updateTotal);
    diAntar.addEventListener('change', updateTotal);
    
    updateTotal();
});
</script>

@endsection