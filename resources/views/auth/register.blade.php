@extends('layouts.app')

@section('title', 'Register - Lumiere Beauty Clinic')

@section('content')
    <main>
        <section class="auth-section">
            <div class="container auth-layout">
                <div class="auth-copy reveal">
                    <span class="eyebrow eyebrow-dark">Join Membership</span>
                    <h1>Create Your Account</h1>
                    <p>
                        Daftar sebagai customer Lumiere Beauty untuk mendapatkan akses booking online,
                        membership points, and member-only promotions.                    </p>

                    <div class="auth-benefit">
                        <h3>Why Join?</h3>
                        <ul>
                            <li>Mulai dari level Bronze</li>
                            <li>Dapatkan poin setelah pembayaran diverifikasi</li>
                            <li>Naik level ke Silver, Gold, dan Platinum</li>
                            <li>Access exclusive membership promotions</li>
                        </ul>
                    </div>
                </div>

                <div class="auth-card reveal">
                    <h2>Register</h2>
                    <p>Buat akun customer Lumiere Beauty.</p>

                    <form action="{{ route('register.store') }}" method="POST" class="auth-form">
                        @csrf

                        <div class="form-group">
                            <label for="name">Nama Lengkap</label>
                            <input
                                type="text"
                                id="name"
                                name="name"
                                value="{{ old('name') }}"
                                placeholder="Masukkan nama lengkap"
                                required
                            >

                            @error('name')
                                <small class="form-error">{{ $message }}</small>
                            @enderror
                        </div>

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
                            <label for="phone">Nomor Telepon</label>
                            <input
                                type="text"
                                id="phone"
                                name="phone"
                                value="{{ old('phone') }}"
                                placeholder="Contoh: 081234567890"
                            >

                            @error('phone')
                                <small class="form-error">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-grid">
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input
                                    type="password"
                                    id="password"
                                    name="password"
                                    placeholder="Minimal 6 karakter"
                                    required
                                >

                                @error('password')
                                    <small class="form-error">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="password_confirmation">Konfirmasi</label>
                                <input
                                    type="password"
                                    id="password_confirmation"
                                    name="password_confirmation"
                                    placeholder="Ulangi password"
                                    required
                                >
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block">
                            Register
                        </button>
                    </form>

                    <p class="auth-switch">
                        Sudah punya akun?
                        <a href="{{ route('login') }}">Login di sini</a>
                    </p>
                </div>
            </div>
        </section>
    </main>
@endsection