@extends('admin.layout.app')

@section('title', 'Menu Managemen')

@section('content')
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">

<div class="menu-management">
    <div class="menu-header">
        <a href="{{ route('admin.menus.create') }}" class="btn-add-new">
            <i class="fas fa-plus"></i> Tambah Menu
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="stat-cards-grid">
        <div class="stat-card-menu">
            <div class="stat-label">Total MENU</div>
            <div class="stat-value">{{ $menus->count() }}</div>
            <div class="stat-change">BULAN INI</div>
        </div>

        <div class="stat-card-menu">
            <div class="stat-label"> Menu Aktif</div>
            <div class="stat-value">{{ $menus->where('stock', '>', 0)->count() }}</div>
            <div class="stat-change active-status">{{ number_format(($menus->where('stock', '>', 0)->count() / max($menus->count(), 1)) * 100, 1) }}% AKTIF</div>
        </div>

        <div class="stat-card-menu">
            <div class="stat-label">Stock habis</div>
            <div class="stat-value">{{ $menus->where('stock', 0)->count() }}</div>
            <div class="stat-change warning-status">HABIS</div>
        </div>
    </div>

    <div class="menu-controls">
        <div class="filter-controls">
            <select id="categoryFilter" class="filter-select" onchange="filterTable()">
                <option value="">Semua Kategori</option>
                @php
                    $categories = [];
                    foreach($menus as $menu) {
                        if($menu->category && !in_array($menu->category->id, array_column($categories, 'id'))) {
                            $categories[] = ['id' => $menu->category->id, 'name' => $menu->category->name];
                        }
                    }
                @endphp
                @foreach($categories as $cat)
                    <option value="{{ $cat['id'] }}">{{ $cat['name'] }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="menu-table-section">
        <table class="menu-table" id="menuTable">
            <thead>
                <tr>
                    <th>PRODUK</th>
                    <th>KATEGORI</th>
                    <th>HARGA</th>
                    <th>STOCK STATUS</th>
                    <th>DETAIL</th>
                </tr>
            </thead>
            <tbody>
                @forelse($menus as $menu)
                    <tr data-category="{{ $menu->category->id ?? '' }}" data-name="{{ $menu->name }}">
                        <td>
                            <div class="product-info">
                                @if($menu->image)
                                    <img src="{{ asset('uploads/menu/'.$menu->image) }}" 
                                         alt="{{ $menu->name }}" class="product-img">
                                @else
                                    <div class="product-img-placeholder">
                                        <i class="fas fa-image"></i>
                                    </div>
                                @endif
                                <div>
                                    <div class="product-name">{{ $menu->name }}</div>
                                    <div class="product-id">ID: {{ strtoupper(substr($menu->id, 0, 2)) }}-{{ str_pad($menu->id, 3, '0', STR_PAD_LEFT) }}-JDX</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="category-badge">{{ $menu->category->name ?? '-' }}</span>
                        </td>
                        <td>
                            <div class="price-info">
                                IDR<br>
                                <strong>{{ number_format($menu->price, 0, ',', '.') }}</strong>
                            </div>
                        </td>
                        <td>
                            <div class="stock-status">
                                @if($menu->status == 'sold_out' || $menu->stock == 0)
                                    <span class="stock-dot out"></span>
                                    <span class="stock-text">Habis</span>
                                @else
                                    <span class="stock-dot ready"></span>
                                    <span class="stock-text">Tersedia</span>
                                @endif
                            </div>
                        </td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('admin.menus.edit', $menu->id) }}" 
                                   class="action-edit" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.menus.destroy', $menu->id) }}" 
                                      method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="action-delete" 
                                            onclick="return confirm('Yakin ingin menghapus menu ini?')"
                                            title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center empty-state">
                            <i class="fas fa-inbox"></i>
                            <p>Belum ada data menu.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

<script>
function filterTable() {
    const categoryFilter = document.getElementById('categoryFilter').value;
    const table = document.getElementById('menuTable');
    const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');
    let visibleCount = 0;

    for (let row of rows) {
        const categoryCell = row.getAttribute('data-category');

        const categoryMatch = categoryFilter === '' || categoryCell === categoryFilter;

        if (categoryMatch) {
            row.style.display = '';
            visibleCount++;
        } else {
            row.style.display = 'none';
        }
    }
}
</script>

@endsection