@extends('layouts.app')

@section('title', 'Profile - Lumiere Beauty Clinic')

@section('content')
    <main>
        <section class="page-hero">
            <div class="container page-hero-content">
                <span class="eyebrow eyebrow-dark">My Account</span>
                <h1>Profile Membership</h1>
                <p>Informasi akun, level membership, dan statistik booking Anda.</p>
            </div>
        </section>

        <section class="section-block">
            <div class="container profile-layout">
                <article class="profile-card reveal">
                    <div class="profile-avatar">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>

                    <h2>{{ $user->name }}</h2>
                    <p>{{ $user->email }}</p>

                    <span class="member-badge {{ strtolower($user->membershipLevel->level_name ?? 'bronze') }}">
                        {{ $user->membershipLevel->level_name ?? 'Bronze' }}
                    </span>
                </article>

                <div class="profile-detail-grid">
                    <article class="info-card reveal">
                        <span class="info-icon">👤</span>
                        <h3>Data Akun</h3>
                        <p>
                            <strong>Nama:</strong> {{ $user->name }}<br>
                            <strong>Email:</strong> {{ $user->email }}<br>
                            <strong>Telepon:</strong> {{ $user->phone ?? '-' }}<br>
                            <strong>Status:</strong> {{ $user->is_active ? 'Aktif' : 'Nonaktif' }}
                        </p>
                    </article>

                    <article class="info-card reveal">
                        <span class="info-icon">✨</span>
                        <h3>Membership</h3>
                        <p>
                            <strong>Level:</strong> {{ $user->membershipLevel->level_name ?? 'Bronze' }}<br>
                            <strong>Total Poin:</strong> {{ $user->total_points }}<br>
                            <strong>Benefit:</strong> {{ $user->membershipLevel->benefits ?? 'Benefit membership dasar.' }}
                        </p>
                    </article>

                    <article class="info-card reveal">
                        <span class="info-icon">📅</span>
                        <h3>Statistik Booking</h3>
                        <p>
                            <strong>Total Booking:</strong> {{ $totalBookings }}<br>
                            <strong>Booking Paid:</strong> {{ $paidBookings }}<br>
                            <strong>Treatment Selesai:</strong> {{ $completedTreatments }}
                        </p>
                    </article>
                </div>
            </div>
        </section>
    </main>
@endsection