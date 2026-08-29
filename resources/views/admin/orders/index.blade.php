@extends('admin.layout.app')

@section('title', 'Order Managemen')

@section('content')

<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
<link rel="stylesheet" href="{{ asset('css/admin-orders.css') }}">

<div class="orders-container">
    
    <!-- Header Section -->
    <div class="orders-header">
        <div class="search-wrapper">
            <form action="{{ route('admin.orders.index') }}" method="GET" class="search-form">
                <i class="fas fa-search"></i>
                    <input 
                        type="text" 
                        name="search" 
                        class="search-input" 
                        placeholder="Cari orderan..."
                        value="{{ request('search') }}">
            </form>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Stat Cards Section -->
    <div class="stat-cards-wrapper">
        <div class="stat-card">
            <div class="stat-label">ORDERAN BARU</div>
            <div class="stat-value">{{ $newOrders }}</div>
            <div class="stat-change">Pesanan Masuk</div>
        </div>

        <div class="stat-card">
            <div class="stat-label">MENUNGGU PROSES</div>
            <div class="stat-value">{{ $pendingOrders }}</div>
            <div class="stat-change">Sedang Diproses</div>
        </div>

        <div class="stat-card">
            <div class="stat-label">ORDERAN SELESAI</div>
            <div class="stat-value">{{ $shippedOrders }}</div>
            <div class="stat-change">Sudah Selesai</div>
        </div>

        <div class="stat-card">
            <div class="stat-label">TOTAL PENDAPATAN</div>
            <div class="stat-value">{{ 'Rp ' . number_format($totalRevenue, 0, ',', '.') }}</div>
            <div class="stat-change">Pendapatan Hari ini</div>
        </div>
    </div>

    <!-- Orders Table Section -->
    <div class="orders-table-section">
        <table class="orders-table">
            <thead>
                <tr>
                    <th>ORDER ID</th>
                    <th>CUSTOMER NAME</th>
                    <th>TOTAL HARGA</th>
                    <th>STATUS</th>
                    <th>DETAIL</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                    <tr>
                        <td>
                            <span class="order-id">#{{ $order->order_number ?? 'N/A' }}-{{ date('md', strtotime($order->created_at)) }}</span>
                        </td>
                        <td>
                            <span class="customer-name">{{ $order->customer_name }}</span>
                        </td>
                        <td>
                            <span class="total-amount">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                        </td>
                        <td>
                            <span class="status-badge status-{{ strtolower(str_replace(' ', '', $order->status)) }}">
                                {{ $order->status }}
                            </span>
                        </td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('admin.orders.show', $order->id) }}" class="action-view" title="View Details">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center empty-state">
                            <i class="fas fa-inbox"></i>
                            <p>Belum ada data pesanan.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Pagination -->
        @if($orders->hasPages())
        <div class="pagination-wrapper">
            <span class="pagination-info">
                Menampilkan {{ $orders->firstItem() }}-{{ $orders->lastItem() }} dari  {{ $orders->total() }} PESANAN
            </span>
            <div class="pagination-controls">
                @if($orders->onFirstPage())
                    <button class="pagination-btn" disabled>
                        <i class="fas fa-chevron-left"></i>
                    </button>
                @else
                    <a href="{{ $orders->previousPageUrl() }}" class="pagination-btn">
                        <i class="fas fa-chevron-left"></i>
                    </a>
                @endif

                @if($orders->hasMorePages())
                    <a href="{{ $orders->nextPageUrl() }}" class="pagination-btn">
                        <i class="fas fa-chevron-right"></i>
                    </a>
                @else
                    <button class="pagination-btn" disabled>
                        <i class="fas fa-chevron-right"></i>
                    </button>
                @endif
            </div>
        </div>
        @endif
    </div>

</div>

@endsection