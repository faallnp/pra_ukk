@extends('user.layout.app')

@section('title', 'Pesanan Berhasil')

@section('content')

<div class="container py-5">

    <div class="row justify-content-center">

        <div class="col-lg-6">

            <div class="card shadow-lg border-0">

                <div class="card-body p-5 text-center">

                    <!-- Success Icon -->
                    <div class="mb-4">

                        <div class="rounded-circle d-inline-flex align-items-center justify-content-center" 
                             style="width: 80px; height: 80px; background-color: #10B981;">
                            <i class="bi bi-check-lg text-white" style="font-size: 40px;"></i>
                        </div>

                    </div>

                    <!-- Title -->
                    <h2 class="fw-bold mb-2" style="color: #4B2E2E;">Pesanan Berhasil!</h2>

                    <p class="text-muted mb-4">
                        Terima kasih kasih, pesanan kamu berhasil dibuat.
                    </p>

                    <!-- Info Box -->
                    <div class="p-4 mb-4" style="background-color: #F5F0EB; border-radius: 12px;">

                        <!-- Nomor Pesanan -->
                        <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom">
                            <span class="text-muted">Nomor Pesanan</span>
                            <strong>#{{ $order->order_number ?? 'N/A' }}</strong>
                        </div>

                        <!-- Total Pembayaran -->
                        <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom">
                            <span class="text-muted">Total Pembayaran</span>
                            <strong style="color: #8B4513;">Rp {{ number_format($order->total,0,',','.') }}</strong>
                        </div>

                        <!-- Metode Pembayaran -->
                        <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom">
                            <span class="text-muted">Metode Pembayaran</span>
                            <strong>{{ $order->payment_method }}</strong>
                        </div>

                        <!-- Metode Pengambilan -->
                        <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom">
                            <span class="text-muted">Metode Pengambilan</span>
                            <strong>{{ $order->delivery_method }}</strong>
                        </div>

                        <!-- Status Pembayaran -->
                        <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom">
                            <span class="text-muted">Status Pembayaran</span>
                            <span class="badge bg-success">{{ $order->payment_status }}</span>
                        </div>

                        <!-- Status -->
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-muted">Status</span>
                            <span class="badge bg-warning text-dark">{{ $order->status }}</span>
                        </div>

                    </div>

                    <!-- Buttons -->
                    <div class="d-flex gap-2 justify-content-center">
                        <a
                            href="{{ route('home') }}"
                            class="btn w-50"
                            style="background-color: #8B4513; color: white;">
                            Kembali ke Home
                        </a>
                        <a
                            href="{{ route('menu') }}"
                            class="btn btn-outline-secondary w-50"
                            style="color: #8B4513; border-color: #8B4513;">
                            Belanja Lagi
                        </a>
                    </div>

                    <!-- Info Message -->
                    <div class="mt-4 pt-3 border-top">
                        <p class="text-muted small mb-0">
                            <i class="bi bi-info-circle"></i> TerimaKasih.
                        </p>
                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection