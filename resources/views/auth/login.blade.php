@extends('user.layout.app')

@section('title', 'Login')

@section('content')

<div class="container py-5">

    <div class="row justify-content-center">

        <div class="col-md-5">

            <div class="card shadow-lg border-0">

                <div class="card-body p-5">

                    <h3 class="text-center mb-4" style="color: #4B2E2E;">Login</h3>

                    @if($errors->any())
                        <div class="alert alert-danger">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('login') }}" method="POST">

                        @csrf

                        <div class="mb-3">

                            <label class="form-label">Email</label>

                            <input
                                type="email"
                                name="email"
                                class="form-control @error('email') is-invalid @enderror"
                                placeholder="gudegenak@email.com"
                                value="{{ old('email') }}"
                                required>

                            @error('email')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror

                        </div>

                        <div class="mb-3">

                            <label class="form-label">Password</label>

                            <input
                                type="password"
                                name="password"
                                class="form-control @error('password') is-invalid @enderror"
                                placeholder="masukan password"
                                required>

                            @error('password')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror

                        </div>

                        <button type="submit" class="btn w-100 mb-3" style="background-color: #8B4513; color: white;">
                            Login
                        </button>

                    </form>

                    <hr>

                    <p class="text-center mb-0">
                        Belum punya akun? 
                        <a href="{{ route('register') }}" style="color: #8B4513; font-weight: 600;">Daftar di sini</a>
                    </p>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection
