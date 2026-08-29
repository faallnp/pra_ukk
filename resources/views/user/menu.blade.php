@extends('user.layout.app')

@section('title', 'Menu')

@section('content')

<section class="menu-header py-5">

    <div class="container">

        <h1 class="menu-title">
            MenuKami
        </h1>

        <p class="menu-description">
           Nikmati pilihan hidangan kami yang kaya akan warisan budaya, 
           dimasak perlahan selama 24 jam untuk menghadirkan cita rasa 
           autentik Yogyakarta bagi Anda.
        </p>

        <!-- Search -->
        <form action="{{ route('menu') }}" method="GET">

            <div class="search-box mt-4">

                <div class="input-group">

                    <input
                        type="text"
                        name="search"
                        class="form-control"
                        value="{{ request('search') }}"
                        placeholder="Cari menu...">

                    <button class="btn btn-search">

                        <i class="bi bi-search"></i>

                    </button>

                </div>

            </div>

        </form>

        <div class="category-wrapper mt-4">

            <a href="{{ route('menu') }}" class="text-decoration-none">
                <x-category-button :active="!request('category')">
                    Semua Menu
                </x-category-button>
            </a>

        @foreach($categories as $category)
            <a
                href="{{ route('menu', ['category' => $category->id]) }}"
                class="text-decoration-none">

                <x-category-button
                    :active="request('category') == $category->id">

                    {{ $category->name }}

                </x-category-button>

            </a>
        @endforeach

        </div>

    </div>

</section>

<section class="py-5">

    <div class="container">

        <div class="row">

            @foreach ($menus as $menu)

                <x-menu-card
                    :id="$menu->id"
                    :image="$menu->image ? 'uploads/menu/'.$menu->image : 'images/gudeg.png'"
                    :title="$menu->name"
                    :description="$menu->description"
                    :price="$menu->price"
                    :status="$menu->status"
                    :stock="$menu->stock"/>

            @endforeach

        </div>

    </div>

</section>


@endsection