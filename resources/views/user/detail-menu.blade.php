@extends('user.layout.app')

@section('title', $menu->name)

@section('content')

<link rel="stylesheet" href="{{ asset('css/detail-menu.css') }}">

<div id="alertNotification" class="alert-notification">
    <span class="alert-text">Menu berhasil ditambahkan ke keranjang!</span>
    <button class="alert-close" onclick="closeAlert()">&times;</button>
</div>

<div class="detail-menu-container">
    
    <!-- Detail Section -->
    <div class="container py-5">
        <div class="row align-items-center">
            
            <!-- Image Column -->
            <div class="col-lg-6 mb-4 mb-lg-0">
                <div class="detail-image-wrapper">
                    <img
                        src="{{ $menu->image ? asset('uploads/menu/'.$menu->image) : asset('images/gudeg.png') }}"
                        class="detail-image"
                        alt="{{ $menu->name }}">
                </div>
            </div>

            <!-- Info Column -->
            <div class="col-lg-6">
                <div class="detail-content">
                    
                    <div class="breadcrumb-nav">
                        <a href="{{ route('menu') }}">Menu</a>
                        <span>&gt;</span>
                        <span>{{ $menu->category->name }}</span>
                    </div>

                    <h1 class="detail-title">{{ $menu->name }}</h1>

                    <p class="detail-category">
                        {{ $menu->category->name }}
                    </p>

                    <div class="detail-price">
                        Rp {{ number_format($menu->price, 0, ',', '.') }}
                    </div>

                    <p class="detail-description">
                        {{ $menu->description }}
                    </p>

                    <div class="detail-info">
                        <div class="info-item">
                            <strong>Stok tersedia:</strong>
                            <span>{{ $menu->stock }}</span>
                        </div>
                    </div>

                    @if($menu->status == 'sold_out' || $menu->stock == 0)
                        <div class="sold-out-message">
                            <i class="fas fa-exclamation-circle"></i>
                            <span>Menu ini sedang tidak tersedia</span>
                        </div>
                    @else
                        <form action="{{ route('cart.add', $menu->id) }}" method="POST" class="detail-form">
                            @csrf

                            <div class="quantity-selector">
                                <button type="button" class="qty-btn qty-minus">−</button>
                                <input type="number" name="quantity" value="1" min="1" max="{{ $menu->stock }}" class="qty-input">
                                <button type="button" class="qty-btn qty-plus">+</button>
                            </div>

                            <div class="form-buttons">
                                <button type="submit" class="btn-add-cart">
                                    <i class="fas fa-shopping-cart"></i>
                                    Masukkan ke Keranjang
                                </button>

                                <button type="button" class="btn-checkout" id="btn-checkout-direct">
                                    <i class="fas fa-shopping-bag"></i>
                                    Checkout Sekarang
                                </button>
                            </div>
                        </form>
                    @endif

                </div>
            </div>

        </div>
    </div>

    <!-- Related Menu Section -->
    @if($relatedMenus->count() > 0)
    <div class="related-menu-section">
        <div class="container">
            
            <div class="section-header">
                <h2>Menu Lainnya</h2>
                <p>Lihat menu favorit lainnya dari kategori {{ $menu->category->name }}</p>
            </div>

            <div class="row">
                @foreach($relatedMenus as $relatedMenu)
                    <x-menu-card
                        :image="$relatedMenu->image ? 'uploads/menu/'.$relatedMenu->image : 'images/gudeg.png'"
                        :title="$relatedMenu->name"
                        :description="$relatedMenu->description"
                        :price="$relatedMenu->price"
                        :id="$relatedMenu->id"
                        :status="$relatedMenu->status"
                        :stock="$relatedMenu->stock"
                    />
                @endforeach
            </div>

        </div>
    </div>
    @endif

</div>

<script>
function showAlert() {
    const alertEl = document.getElementById('alertNotification');
    alertEl.classList.add('show');
    alertEl.classList.remove('hide');

    setTimeout(() => {
        closeAlert();
    }, 3000);
}

function closeAlert() {
    const alertEl = document.getElementById('alertNotification');
    alertEl.classList.add('hide');
    alertEl.classList.remove('show');

    setTimeout(() => {
        alertEl.classList.remove('hide');
    }, 300);
}

document.addEventListener('DOMContentLoaded', function() {
    const qtyInput = document.querySelector('.qty-input');
    const qtyMinus = document.querySelector('.qty-minus');
    const qtyPlus = document.querySelector('.qty-plus');
    const maxStock = parseInt(qtyInput.getAttribute('max'));
    const checkoutBtn = document.getElementById('btn-checkout-direct');
    const addCartBtn = document.querySelector('.btn-add-cart');
    const form = document.querySelector('.detail-form');
    const menuId = {{ $menu->id }};

    qtyMinus.addEventListener('click', function() {
        let currentQty = parseInt(qtyInput.value);
        if (currentQty > 1) {
            qtyInput.value = currentQty - 1;
        }
    });

    qtyPlus.addEventListener('click', function() {
        let currentQty = parseInt(qtyInput.value);
        if (currentQty < maxStock) {
            qtyInput.value = currentQty + 1;
        }
    });

    addCartBtn.addEventListener('click', function(e) {
        e.preventDefault();
        const quantity = parseInt(qtyInput.value);
        const formData = new FormData(form);
        formData.append('quantity', quantity);

        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showAlert();
                qtyInput.value = 1;
            }
        })
        .catch(error => console.error('Error:', error));
    });

    checkoutBtn.addEventListener('click', function(e) {
        e.preventDefault();
        const quantity = parseInt(qtyInput.value);

        const checkoutForm = document.createElement('form');
        checkoutForm.method = 'POST';
        checkoutForm.action = '{{ route("checkout.direct", "") }}/' + menuId;

        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = '{{ csrf_token() }}';
        checkoutForm.appendChild(csrfInput);

        const quantityInput = document.createElement('input');
        quantityInput.type = 'hidden';
        quantityInput.name = 'quantity';
        quantityInput.value = quantity;
        checkoutForm.appendChild(quantityInput);

        document.body.appendChild(checkoutForm);
        checkoutForm.submit();
    });
});
</script>

@endsection