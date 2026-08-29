@extends('admin.layout.app')

@section('title', 'Edit Menu')

@section('content')

<link rel="stylesheet" href="{{ asset('css/admin-menu.css') }}">

<div class="menu-form-container">
    <div class="menu-form-header">
        <div>
            <a href="{{ route('admin.menus.index') }}" class="breadcrumb-link">Menu Managemen</a>
            <span class="breadcrumb-separator">&gt;</span>
            <span class="breadcrumb-current">Edit Menu</span>
        </div>
        <div class="header-actions">
            <form action="{{ route('admin.menus.destroy', $menu->id) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-delete" onclick="return confirm('Yakin ingin menghapus menu ini?')">
                    <i class="fas fa-trash"></i> Hapus Menu
                </button>
            </form>
        </div>
    </div>

    <form action="{{ route('admin.menus.update', $menu->id) }}" method="POST" enctype="multipart/form-data" class="menu-form">
        @csrf
        @method('PUT')

        <div class="form-layout">
            <!-- Left Column -->
            <div class="form-left">
                
                <!-- Basic Information Section -->
                <div class="form-section">
                    <h3 class="section-title">Informasi</h3>

                    <div class="form-group">
                        <label class="form-label">Nama Menu <span class="required">*</span></label>
                        <input
                            type="text"
                            name="name"
                            class="form-input @error('name') is-invalid @enderror"
                            value="{{ old('name', $menu->name) }}"
                            placeholder="Enter menu name"
                            required>
                        @error('name')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Deskripsi</label>
                        <textarea
                            name="description"
                            class="form-textarea @error('description') is-invalid @enderror"
                            rows="5"
                            placeholder="masukan deskripsi menu"
                            maxlength="500">{{ old('description', $menu->description) }}</textarea>
                        <div class="char-counter">
                            <span id="charCount">{{ strlen($menu->description) }}</span> / 500 characters
                        </div>
                        @error('description')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Kategori <span class="required">*</span></label>
                        <select
                            name="category_id"
                            class="form-select @error('category_id') is-invalid @enderror"
                            required>
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ old('category_id', $menu->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <!-- Pricing & Inventory Section -->
                <div class="form-section">
                    <h3 class="section-title">Harga & Stock</h3>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Harga <span class="required">*</span></label>
                            <input
                                type="number"
                                name="price"
                                class="form-input @error('price') is-invalid @enderror"
                                value="{{ old('price', $menu->price) }}"
                                placeholder="0"
                                required>
                            @error('price')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">Stock <span class="required">*</span></label>
                            <input
                                type="number"
                                name="stock"
                                class="form-input @error('stock') is-invalid @enderror"
                                value="{{ old('stock', $menu->stock) }}"
                                placeholder="0"
                                required>
                            @error('stock')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Status</label>
                        <div class="radio-group">
                            <label class="radio-label">
                                <input type="radio" name="status" value="available" 
                                    {{ old('status', $menu->status) == 'available' ? 'checked' : '' }}>
                                <span>Tersedia</span>
                            </label>
                            <label class="radio-label">
                                <input type="radio" name="status" value="sold_out"
                                    {{ old('status', $menu->status) == 'sold_out' ? 'checked' : '' }}>
                                <span>Habis</span>
                            </label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="radio-label">
                            <input type="checkbox" name="is_favorite" value="1" {{ old('is_favorite', $menu->is_favorite) ? 'checked' : '' }}>
                            <span>Jadikan Favorit</span>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="form-right">
                
                <!-- Item Image Section -->
                <div class="form-section">
                    <h3 class="section-title">Gambar Produk</h3>

                    <div class="image-preview-container">
                        <div class="image-preview" id="imagePreview">
                            @if($menu->image)
                                <img src="{{ asset('uploads/menu/'.$menu->image) }}" alt="{{ $menu->name }}">
                            @else
                                <i class="fas fa-image"></i>
                                <p>Tidak ada gambar</p>
                            @endif
                        </div>
                    </div>

                    <div class="image-recommended">
                        Recommended size: 800x600px<br>
                        (JPG, PNG)
                    </div>

                    <div class="form-group">
                        <input
                            type="file"
                            name="image"
                            class="form-file"
                            id="imageInput"
                            accept="image/jpg,image/jpeg,image/png">
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn-save">
                            <i class="fas fa-check"></i> Simpan Perubahan
                        </button>
                        <a href="{{ route('admin.menus.index') }}" class="btn-cancel">
                            kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Character counter
    const descriptionTextarea = document.querySelector('textarea[name="description"]');
    const charCount = document.getElementById('charCount');
    
    if (descriptionTextarea) {
        descriptionTextarea.addEventListener('input', function() {
            charCount.textContent = this.value.length;
        });
    }

    // Image preview
    const imageInput = document.getElementById('imageInput');
    const imagePreview = document.getElementById('imagePreview');

    if (imageInput) {
        imageInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    imagePreview.innerHTML = '<img src="' + event.target.result + '" alt="Preview">';
                };
                reader.readAsDataURL(file);
            }
        });
    }
});
</script>

@endsection