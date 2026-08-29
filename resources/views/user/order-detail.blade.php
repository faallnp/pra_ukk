@extends('user.layout.app')

@section('title', 'Detail Pesanan')

@section('content')

<div class="container py-5">

    <div class="mb-4">
        <h2 style="color: #4B2E2E;">Detail Pesanan</h2>
        <p class="text-muted">Order #{{ $order->order_number ?? 'N/A' }}</p>
    </div>

    <!-- Header: Order ID, Status, Date -->
    <div class="row mb-4">
        <div class="col-md-12">
            <p class="mb-1"><strong>Order #{{ $order->order_number ?? 'N/A' }}</strong></p>
            <p class="text-muted small mb-2">{{ $order->created_at->format('d F Y') }}</p>
            <span class="badge" style="background-color: 
                @if($order->status === 'Selesai') #10B981
                @elseif($order->status === 'Diproses') #F59E0B
                @elseif($order->status === 'Ditolak' || $order->status === 'Dibatalkan') #EF4444
                @else #9CA3AF
                @endif
            ;">
                {{ $order->status }}
            </span>
        </div>
    </div>

    <!-- Section 1: Informasi Pengiriman -->
    <div class="card shadow-sm mb-4" style="background-color: #ffffff; border: 1px solid #D2C2B5; border-radius: 12px;">
        <div class="card-body">
            <h6 class="mb-3" style="color: #8B4513;">
                <i class="bi bi-geo-alt"></i> Informasi Pengiriman
            </h6>
            <p class="mb-1"><strong>{{ $order->customer_name }}</strong></p>
            <p class="mb-1 text-muted">{{ $order->phone }}</p>
            <p class="text-muted">{{ $order->address }}</p>
        </div>
    </div>

    <!-- Section 2: Rincian Pesanan -->
    <div class="card shadow-sm mb-4" style="background-color: #ffffff; border: 1px solid #D2C2B5; border-radius: 12px;">
        <div class="card-body">
            <h6 class="mb-3" style="color: #8B4513;">
                <i class="bi bi-bag-check"></i> Rincian Pesanan
            </h6>

            @foreach($order->items as $item)
                <div class="row align-items-center mb-3 pb-3 border-bottom">
                    <div class="col-2 text-center">
                        @if($item->menu && $item->menu->image)
                            <img src="{{ asset('uploads/menu/'.$item->menu->image) }}" class="img-fluid rounded" style="height: 60px; object-fit: cover;">
                        @else
                            <div style="height: 60px; background-color: #f0f0f0; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                <i class="bi bi-image"></i>
                            </div>
                        @endif
                    </div>
                    <div class="col-6">
                        <p class="mb-1"><strong>{{ $item->menu->name ?? 'Menu Tidak Tersedia' }}</strong></p>
                        <p class="mb-0 small text-muted">x{{ $item->qty }}</p>
                    </div>
                    <div class="col-4 text-end">
                        <p class="mb-0" style="color: #8B4513;"><strong>Rp {{ number_format($item->subtotal,0,',','.') }}</strong></p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Section 3: Metode Info (2 columns) -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card shadow-sm" style="background-color: #ffffff; border: 1px solid #D2C2B5; border-radius: 12px;">
                <div class="card-body text-center">
                    <p class="text-muted small mb-2">Metode Pembayaran</p>
                    <p class="mb-0"><strong>{{ $order->payment_method }}</strong></p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow-sm" style="background-color: #ffffff; border: 1px solid #D2C2B5; border-radius: 12px;">
                <div class="card-body text-center">
                    <p class="text-muted small mb-2">Metode Pengiriman</p>
                    <p class="mb-0"><strong>{{ $order->delivery_method }}</strong></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Section 4: Ringkasan Pembayaran -->
    <div class="card shadow-sm mb-4" style="background-color: #ffffff; border: 1px solid #D2C2B5; border-radius: 12px;">
        <div class="card-body">
            <h6 class="mb-3" style="color: #8B4513;">Ringkasan Pembayaran</h6>

            <div class="d-flex justify-content-between mb-2">
                <span class="text-muted">Subtotal</span>
                <span>Rp {{ number_format($order->total - $order->shipping_cost,0,',','.') }}</span>
            </div>

            @if($order->shipping_cost > 0)
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Ongkos Kirim</span>
                    <span>Rp {{ number_format($order->shipping_cost,0,',','.') }}</span>
                </div>
            @endif

            <hr>

            <div class="d-flex justify-content-between fw-bold">
                <span>Total</span>
                <span style="color: #8B4513; font-size: 18px;">Rp {{ number_format($order->total,0,',','.') }}</span>
            </div>
        </div>
    </div>

    <!-- Button: Kembali ke Home -->
    <div class="text-center">
        <a href="{{ route('home') }}" class="btn" style="background-color: #8B4513; color: white;">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

</div>

@endsection
