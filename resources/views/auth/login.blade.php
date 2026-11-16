@extends('layouts.app')

@section('title', 'Login - Lumiere Beauty Clinic')

@section('content')
    <main>
        <section class="auth-section">
            <div class="container auth-layout">
                <div class="auth-copy reveal">
                    <span class="eyebrow eyebrow-dark">Member Access</span>
                    <h1>Welcome Back</h1>
                    <p>
                        Login untuk melakukan booking treatment, melihat riwayat pembayaran,
                        mengecek poin, dan mengakses benefit membership Lumiere Beauty.
                    </p>

                    <div class="auth-benefit">
                        <h3>Member Benefit</h3>
                        <ul>
                            <li>Booking treatment online</li>
                            <li>Riwayat pembayaran dan receipt</li>
                            <li>Point membership dari transaksi paid</li>
                            <li>Promo khusus sesuai level membership</li>
                        </ul>
                    </div>
                </div>

                <div class="auth-card reveal">
                    <h2>Login</h2>
                    <p>Masuk ke akun Lumiere Beauty.</p>

                    <form action="{{ route('login.store') }}" method="POST" class="auth-form">
                        @csrf

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input
                                type="email"
                                id="email"
                                name="email"
                                value="{{ old('email') }}"
                                placeholder="Masukkan email"
                                required
                            >

                            @error('email')
                                <small class="form-error">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password">Password</label>
                            <input
                                type="password"
                                id="password"
                                name="password"
                                placeholder="Masukkan password"
                                required
                            >

                            @error('password')
                                <small class="form-error">{{ $message }}</small>
                            @enderror
                        </div>

                        <label class="checkbox-line">
                            <input type="checkbox" name="remember" value="1">
                            <span>Ingat saya</span>
                        </label>

                        <button type="submit" class="btn btn-primary btn-block">
                            Login
                        </button>
                    </form>

                    <p class="auth-switch">
                        Belum punya akun?
                        <a href="{{ route('register') }}">Register sekarang</a>
                    </p>

                </div>
            </div>
        </section>
    </main>
@endsection