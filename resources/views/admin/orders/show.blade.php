@extends('admin.layout.app')

@section('title','Detail Pesanan')

@section('content')

<link rel="stylesheet" href="{{ asset('css/admin-menu.css') }}">

@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

<div class="order-detail-container">
    <div class="order-detail-header">
        <div>
            <a href="{{ route('admin.orders.index') }}" class="breadcrumb-link">Order Managemen</a>
            <span class="breadcrumb-separator">&gt;</span>
            <span class="breadcrumb-current">Detail Pesanan #{{ $order->order_number ?? $order->id }}</span>
        </div>
    </div>

    <div class="form-layout">
        <div class="form-left">
            <div class="form-section">
                <h3 class="section-title">Data Pelanggan</h3>

                <div class="order-info">
                    <div class="info-row">
                        <div class="info-label">Nomor Pesanan</div>
                        <div class="info-value">{{ $order->order_number ?? 'N/A' }}</div>
                    </div>

                    <div class="info-row">
                        <div class="info-label">Nama</div>
                        <div class="info-value">{{ $order->customer_name }}</div>
                    </div>

                    <div class="info-row">
                        <div class="info-label">No HP</div>
                        <div class="info-value">{{ $order->phone }}</div>
                    </div>

                    <div class="info-row">
                        <div class="info-label">Alamat</div>
                        <div class="info-value">{{ $order->address }}</div>
                    </div>

                    <div class="info-row">
                        <div class="info-label">Total</div>
                        <div class="info-value"><strong>Rp {{ number_format($order->total,0,',','.') }}</strong></div>
                    </div>

                    <div class="info-row">
                        <div class="info-label">Metode Pembayaran</div>
                        <div class="info-value">{{ $order->payment_method }}</div>
                    </div>

                    <div class="info-row">
                        <div class="info-label">Status Pembayaran</div>
                        <div class="info-value">
                            @if($order->payment_status == 'Lunas')
                                <span class="badge bg-success">Lunas</span>
                            @elseif($order->payment_status == 'Ditolak')
                                <span class="badge bg-danger">Ditolak</span>
                            @else
                                <span class="badge bg-warning text-dark">Menunggu Verifikasi</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-section">
                <h3 class="section-title">Menu yang Dipesan</h3>

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Menu</th>
                            <th>Total</th>
                            <th>Harga</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                            <tr>
                                <td>{{ $item->menu->name }}</td>
                                <td>{{ $item->qty }}</td>
                                <td>Rp {{ number_format($item->price,0,',','.') }}</td>
                                <td>Rp {{ number_format($item->subtotal,0,',','.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="form-section">
                <h3 class="section-title">Update Status</h3>

                <form action="{{ route('admin.orders.update',$order->id) }}" method="POST">
                    @csrf
                    @method('PATCH')

                    <div class="form-group">
                        <label class="form-label">Status Pembayaran</label>
                        <select name="payment_status" class="form-select">
                            <option value="Menunggu Verifikasi" {{ $order->payment_status=='Menunggu Verifikasi' ? 'selected' : '' }}>
                                Menunggu Verifikasi
                            </option>
                            <option value="Lunas" {{ $order->payment_status=='Lunas' ? 'selected' : '' }}>
                                Lunas
                            </option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Status Pesanan</label>
                        <select name="status" class="form-select">
                            <option value="Menunggu" {{ $order->status=='Menunggu' ? 'selected' : '' }}>
                                Menunggu
                            </option>
                            <option value="Diproses" {{ $order->status=='Diproses' ? 'selected' : '' }}>
                                Diproses
                            </option>
                            <option value="Selesai" {{ $order->status=='Selesai' ? 'selected' : '' }}>
                                Selesai
                            </option>
                            <option value="Ditolak" {{ $order->status=='Ditolak' ? 'selected' : '' }}>
                                Ditolak
                            </option>
                        </select>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn-save">
                            <i class="fas fa-save"></i> Simpan Perubahan
                        </button>
                        <a href="{{ route('admin.orders.index') }}" class="btn-cancel">
                            Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <div class="form-right">
            <div class="form-section">
                <h3 class="section-title">Bukti Pembayaran</h3>

                <div class="payment-proof-container">
                    @if($order->payment_proof)
                        <img
                            src="{{ asset('uploads/payment/'.$order->payment_proof) }}"
                            class="payment-proof-image"
                            alt="Bukti Pembayaran">
                    @else
                        <div class="payment-proof-empty">
                            <i class="fas fa-file-image"></i>
                            <p>Belum ada bukti pembayaran</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.order-detail-container {
    padding: 40px 0;
}

.order-detail-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
    padding: 0 20px;
}

.order-info {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.info-row {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    padding-bottom: 15px;
    border-bottom: 1px solid #F5E6D3;
}

.info-row:last-child {
    border-bottom: none;
}

.info-label {
    font-weight: 600;
    color: #4B2E2E;
    min-width: 150px;
    font-size: 14px;
}

.info-value {
    color: #6B3F1D;
    font-size: 14px;
    text-align: right;
    flex: 1;
}

.payment-proof-container {
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 300px;
    background-color: #FFF8F0;
    border: 2px dashed #E0D5C7;
    border-radius: 12px;
}

.payment-proof-image {
    max-width: 100%;
    max-height: 100%;
    border-radius: 8px;
    object-fit: cover;
}

.payment-proof-empty {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    text-align: center;
    color: #999;
}

.payment-proof-empty i {
    font-size: 48px;
    color: #D2A679;
    margin-bottom: 10px;
}

.payment-proof-empty p {
    margin: 0;
    font-size: 14px;
}

@media (max-width: 1024px) {
    .form-layout {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 768px) {
    .order-detail-container {
        padding: 20px 0;
    }

    .order-detail-header {
        padding: 0 15px;
    }

    .info-row {
        flex-direction: column;
        gap: 8px;
    }

    .info-value {
        text-align: left;
    }
}
</style>

@endsection