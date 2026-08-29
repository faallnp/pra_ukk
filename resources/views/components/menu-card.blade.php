@props([
    'image',
    'title',
    'description',
    'price',
    'id',
    'status' => 'available',
    'stock' => 0
])

<div class="col-lg-4 col-md-6 mb-4">

    <div class="menu-card">

        <div class="menu-image-wrapper">
            <img
                src="{{ asset($image) }}"
                alt="{{ $title }}"
                class="menu-image">
            
            @if($status == 'sold_out' || $stock == 0)
                <div class="sold-out-badge">Sold Out</div>
            @endif
        </div>

        <div class="menu-body">

            <h5 class="menu-name">
                {{ $title }}
            </h5>

            <div class="menu-info">

                <span class="price">
                    Rp {{ number_format($price,0,',','.') }}
                </span>

            </div>

            <p class="menu-description">
                {{ $description }}
            </p>

            <a href="{{ route('menu.show', $id) }}" class="btn-order">
                Pesan Sekarang
            </a>
        </div>
    </div>
</div>