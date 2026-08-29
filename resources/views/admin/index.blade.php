@extends('admin.layout.app')

@section('title', 'Dashboard')

@section('content')
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">

<div class="dashboard-wrapper">
    <!-- Summary Header -->
    <div class="summary-header">
        <div>
            <h2 class="summary-title"></h2>
            <p class="summary-subtitle"></p>
        </div>
    </div>

    <!-- Stats Row -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6">
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-receipt"></i></div>
                <div class="stat-label">TOTAL ORDERAN</div>
                <div class="stat-value">{{ $totalOrder ?? '00' }}</div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-utensils"></i></div>
                <div class="stat-label">MENU</div>
                <div class="stat-value">{{ $totalMenu ?? '00' }}</div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-hourglass-half"></i></div>
                <div class="stat-label">ORDERAN MENUNGGU</div>
                <div class="stat-value">{{ $pendingOrder ?? '00' }}</div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-wallet"></i></div>
                <div class="stat-label">TOTAL PENDAPATAN</div>
                <div class="stat-value">Rp {{ number_format($totalRevenue ?? 0, 0, ',', '.') }}</div>
            </div>
        </div>
    </div>

    <!-- Recent Orders -->
    <div class="row">
        <div class="col-12">
            <div class="table-section">
                <div class="table-header">
                    <h3 class="table-title">Riwayat Orderan</h3>
                    <a href="{{ route('admin.orders.index') }}" class="view-all-link">Lihat semua →</a>
                </div>

                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ORDER ID</th>
                                <th>CUSTOMER</th>
                                <th>TOTAL</th>
                                <th>STATUS</th>
                                <th>DETAIL</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentOrders ?? [] as $order)
                                <tr>
                                    <td class="order-id">#{{ $order->order_number ?? 'N/A' }}-{{ date('md', strtotime($order->created_at)) }}</td>
                                    <td class="customer-name">
                                        <span class="customer-initial">{{ strtoupper(substr($order->customer_name ?? 'N', 0, 1)) }}</span>
                                        {{ $order->customer_name ?? 'N/A' }}
                                    </td>
                                    <td class="order-total">Rp {{ number_format($order->total ?? 0, 0, ',', '.') }}</td>
                                    <td>
                                        @php
                                            $statusClass = '';
                                             $statusText = '';
                                             switch($order->status ?? '') {
                                                 case 'Menunggu':
                                                     $statusClass = 'status-pending';
                                                     $statusText = 'MENUNGGU';
                                                     break;
                                                 case 'Diproses':
                                                     $statusClass = 'status-processing';
                                                     $statusText = 'DIPROSES';
                                                     break;
                                                 case 'Selesai':
                                                     $statusClass = 'status-completed';
                                                     $statusText = 'SELESAI';
                                                     break;
                                                 case 'Ditolak':
                                                     $statusClass = 'status-cancelled';
                                                     $statusText = 'DITOLAK';
                                                     break;
                                                 case 'Dibatalkan':
                                                     $statusClass = 'status-cancelled';
                                                     $statusText = 'DIBATALKAN';
                                                     break;
                                                 default:
                                                     $statusClass = 'status-pending';
                                                     $statusText = $order->status ?? 'Unknown';
                                             }
                                        @endphp
                                        <span class="status-badge {{ $statusClass }}">{{ $statusText }}</span>
                                    </td>
                                    <td style="text-align: center;">
                                        <a href="{{ route('admin.orders.show', $order->id) }}" class="action-btn">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" style="text-align: center; padding: 20px; color: #999;">Tidak ada pesanan</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const dateEl = document.getElementById('currentDate');
        const today = new Date();
        const options = { year: 'numeric', month: 'short', day: 'numeric' };
        dateEl.textContent = today.toLocaleDateString('en-US', options);

        const ctx = document.getElementById('orderTrendsChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Ming'],
                datasets: [
                    {
                        label: 'Orders',
                        data: [45, 38, 52, 48, 65, 58, 72],
                        borderColor: '#8B4513',
                        backgroundColor: 'rgba(139, 69, 19, 0.1)',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.4,
                        pointRadius: 5,
                        pointBackgroundColor: '#8B4513',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                    },
                    {
                        label: 'Target',
                        data: [50, 50, 50, 50, 50, 50, 50],
                        borderColor: '#ddd',
                        borderDash: [5, 5],
                        borderWidth: 1,
                        fill: false,
                        pointRadius: 0,
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        display: true,
                        labels: {
                            font: { size: 12, weight: '600' },
                            color: '#666',
                            usePointStyle: true,
                            padding: 20
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100,
                        grid: { color: '#f0f0f0' },
                        ticks: { color: '#999' }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { color: '#999' }
                    }
                }
            }
        });
    });
</script>
@endsection
