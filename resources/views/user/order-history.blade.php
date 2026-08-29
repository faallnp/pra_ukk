@extends('user.layout.app')

@section('title', 'Riwayat Pesanan')

@section('content')

<div class="container py-5">

    <div class="mb-4">
        <h2 style="color: #4B2E2E;">Riwayat Pesanan</h2>
        <p class="text-muted">Lihat daftar pesanan Anda sebelumnya.</p>
    </div>

    @if($orders->count() > 0)

        @foreach($orders as $order)

            <div class="card shadow-sm mb-4" style="background-color: #ffffFf; border: 1px solid #D2C2B5; border-radius: 12px;">

                <div class="card-body">

                    <div class="row align-items-start">

                        <!-- Kolom Kiri: Info Pesanan -->
                        <div class="col-md-8">

                            <p class="text-muted small mb-1">{{ $order->created_at->format('d F Y') }}</p>
                            <h6 class="mb-2">#{{ $order->order_number ?? 'N/A' }}</h6>
                            
                            <span class="badge mb-3" style="background-color: 
                                @if($order->status === 'Selesai') #10B981
                                @elseif($order->status === 'Diproses') #F59E0B
                                @elseif($order->status === 'Ditolak' || $order->status === 'Dibatalkan') #EF4444
                                @else #9CA3AF
                                @endif
                            ;">
                                {{ $order->status }}
                            </span>

                            <!-- Daftar Menu -->
                            <ul class="list-unstyled mb-3">
                                @foreach($order->items as $item)
                                    <li class="mb-2">
                                        <small>{{ $item->menu->name ?? 'Menu Tidak Tersedia' }} x{{ $item->qty }}</small>
                                    </li>
                                @endforeach
                            </ul>

                        </div>

                        <!-- Kolom Kanan: Total & Tombol -->
                        <div class="col-md-4 text-end">

                            <div class="mb-3">
                                <p class="text-muted small mb-1">Total Harga</p>
                                <h6 style="color: #8B4513;">Rp {{ number_format($order->total,0,',','.') }}</h6>
                            </div>

                            <div class="d-flex gap-2 justify-content-end">

                                <a href="{{ route('order.detail', $order->id) }}" class="btn btn-sm btn-outline-secondary" style="color: #8B4513; border-color: #8B4513;">
                                    Detail Pesanan
                                </a>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        @endforeach

    @else

        <div class="alert alert-info text-center py-5">

            <h5>Belum Ada Pesanan</h5>

            <p class="mb-4">Anda belum pernah melakukan pesanan sebelumnya.</p>

            <a href="{{ route('menu') }}" class="btn" style="background-color: #8B4513; color: white;">
                <i class="bi bi-bag-check"></i> Mulai Pesan Sekarang
            </a>

        </div>

    @endif

</div>

@endsection
