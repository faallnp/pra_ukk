@extends('user.layout.app')

@section('title', 'Register')

@section('content')

<div class="container py-5">

    <div class="row justify-content-center">

        <div class="col-md-5">

            <div class="card shadow-lg border-0">

                <div class="card-body p-5">

                    <h3 class="text-center mb-4" style="color: #4B2E2E;">Daftar Akun</h3>

                    @if($errors->any())
                        <div class="alert alert-danger">
                            @foreach($errors->all() as $error)
                                <div>{{ $error }}</div>
                            @endforeach
                        </div>
                    @endif

                    <form action="{{ route('register') }}" method="POST">

                        @csrf

                        <div class="mb-3">

                            <label class="form-label">Nama Lengkap</label>

                            <input
                                type="text"
                                name="name"
                                class="form-control @error('name') is-invalid @enderror"
                                placeholder="Namamu"
                                value="{{ old('name') }}"
                                required>

                            @error('name')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror

                        </div>

                        <div class="mb-3">

                            <label class="form-label">Email</label>

                            <input
                                type="email"
                                name="email"
                                class="form-control @error('email') is-invalid @enderror"
                                placeholder="Gudegenak@email.com"
                                value="{{ old('email') }}"
                                required>

                            @error('email')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror

                        </div>

                        <div class="mb-3">

                            <label class="form-label">Nomor WhatsApp (Opsional)</label>

                            <div class="input-group">

                                <span class="input-group-text">+62</span>

                                <input
                                    type="text"
                                    name="phone"
                                    class="form-control @error('phone') is-invalid @enderror"
                                    placeholder="812-3456-7890"
                                    value="{{ old('phone') }}">

                                @error('phone')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror

                            </div>

                        </div>

                        <div class="mb-3">

                            <label class="form-label">Password</label>

                            <input
                                type="password"
                                name="password"
                                class="form-control @error('password') is-invalid @enderror"
                                placeholder="buat password"
                                required>

                            @error('password')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror

                        </div>

                        <div class="mb-3">

                            <label class="form-label">Konfirmasi Password</label>

                            <input
                                type="password"
                                name="password_confirmation"
                                class="form-control"
                                placeholder="konfirmasi password"
                                required>

                        </div>

                        <button type="submit" class="btn w-100 mb-3" style="background-color: #8B4513; color: white;">
                            Daftar
                        </button>

                    </form>

                    <hr>

                    <p class="text-center mb-0">
                        Sudah punya akun? 
                        <a href="{{ route('login') }}" style="color: #8B4513; font-weight: 600;">Login di sini</a>
                    </p>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection
