@extends('user.layout.app')

@section('title', 'Pembayaran')

@section('content')

<link rel="stylesheet" href="{{ asset('css/payment.css') }}">

<div class="payment-container">

    <div class="payment-header">
        <h2 style="color: #4B2E2E;">Pembayaran</h2>
        <p class="text-muted">Silakan lakukan pembayaran dengan QRIS berikut:</p>
    </div>

    <div class="payment-card">

        <div class="qr-section">
            <img src="{{ asset('images/qris.png') }}" alt="QRIS Code" class="qr-code">
        </div>

        <div class="info-section">
            <div class="info-item">
                <label>Metode Pembayaran</label>
                <strong>QRIS</strong>
            </div>
            <div class="info-item">
                <label>Metode Pengiriman</label>
                <strong>{{ session('checkout')['delivery_method'] }}</strong>
            </div>
            <div class="info-item">
                <label>Nama</label>
                <strong>{{ session('checkout')['customer_name'] }}</strong>
            </div>
            <div class="info-item">
                <label>Nomor HP</label>
                <strong>{{ session('checkout')['phone'] }}</strong>
            </div>
        </div>

        <hr>

        <div class="total-section">
            <div class="total-row">
                <span>Subtotal</span>
                <strong style="color: #8B4513;">Rp {{ number_format($subtotal, 0, ',', '.') }}</strong>
            </div>
            <div class="total-row">
                <span>Ongkos Kirim</span>
                <strong style="color: #8B4513;">Rp {{ $shipping_cost > 0 ? '15.000' : '0' }}</strong>
            </div>
            <hr>
            <div class="total-row">
                <span>Total</span>
                <strong style="color: #8B4513; font-size: 18px;">Rp {{ number_format($total, 0, ',', '.') }}</strong>
            </div>
        </div>

        <hr>

        <form action="{{ route('payment.process') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="upload-section">
                <label class="upload-label">
                    Upload Bukti Pembayaran
                    <input type="file" name="payment_proof" class="form-control" required>
                </label>
            </div>

            <button type="submit" class="btn-pay">
                Konfirmasi Pembayaran
            </button>
        </form>

    </div>

</div>

@endsection