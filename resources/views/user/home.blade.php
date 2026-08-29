@extends('user.layout.app')

@section('title', 'Home')

@section('content')

<section class="hero">

    <div class="container">

        <div class="row align-items-center">

            <!-- Kiri -->
            <div class="col-lg-6">

                <span class="hero-badge">
                    auntentik traditional
                </span>

                <h1 class="hero-title mt-4">
                    Gudeg Yu yem
                </h1>

                <p class="hero-text mt-3">

                    Nikmati cita rasa Gudeg khas Yogyakarta
                    dengan resep turun-temurun yang
                    menghadirkan rasa autentik.

                </p>

                <a href="menu" class="btn hero-btn mt-4">

                    Explore Menu

                </a>

            </div>

            <!-- Kanan -->
            <div class="col-lg-6 text-center">

                <img
                    src="{{ asset('image/NagumoXOsaragi.jpeg') }}"
                    class="img-fluid hero-image"
                    alt="Gudeg">

            </div>

        </div>

    </div>

</section>

<section class="py-5">

    <div class="container">

        <div class="text-center mb-5">

            <h2>Mengapa Memilih Kami?</h2>

            <p>
                Gudeg dibuat menggunakan resep asli
                dengan bahan pilihan terbaik.
            </p>

        </div>

        <div class="row">

            <x-feature-card
                icon="bi bi-basket"
                title="Bahan-bahan Segar"
                description="Menggunakan bahan berkualitas setiap hari."
            />

            <x-feature-card
                icon="bi bi-award"
                title="Resep Tradisional"
                description="Resep turun-temurun dari Keluarga."
            />

            <x-feature-card
                icon="bi bi-star"
                title="Kualitas Premium"
                description="Rasa autentik dengan kualitas terbaik."
            />

        </div>

    </div>

</section>

<section class="py-5">

    <div class="container">

        <div class="text-center mb-5">

            <h2 class="fw-bold">
                Menu Favorit
            </h2>

            <p class="text-muted">
                Nikmati menu andalan kami.
            </p>

        </div>

        <div class="row">

    @foreach($menus as $menu)

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