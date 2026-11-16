@extends('layouts.app')

@section('title', 'Promotions - Lumiere Beauty Clinic')

@section('content')
    <main>
        <section class="page-hero">
            <div class="container page-hero-content">
                <span class="eyebrow eyebrow-dark">Special Offers</span>
                <h1>Promotions</h1>
                <p>Explore active promotions for public customers and Lumiere Beauty members.</p>            </div>
        </section>

        <section class="promotions section-block">
            <div class="container">
                <div class="promo-grid">
                    @forelse($promotions as $promotion)
                        <article class="promotion-card reveal {{ $promotion->membership_only ? 'accent-card' : '' }}">
                            <span class="promo-tag">
                                {{ $promotion->membership_only ? 'Member Promotion' : 'Public Promotion' }}                            </span>

                            <h3>{{ $promotion->title }}</h3>

                            <p>{{ $promotion->description }}</p>

                            <p class="promotion-discount">
                                {{ number_format($promotion->discount_percent, 0) }}% OFF
                            </p>

                            @if($promotion->promo_code)
                                <p>
                                    Code:
                                    <strong>{{ $promotion->promo_code }}</strong>
                                </p>
                            @endif

                            @if($promotion->membership_only)
                                <p>
                                    Minimum:
                                    <strong>{{ $promotion->minimumMembershipLevel->level_name ?? 'Member' }}</strong>
                                </p>

                                @auth
                                    @if(auth()->user()->membership_level_id >= $promotion->minimum_membership_level_id)
                                        <span class="status-pill status-paid">Dapat digunakan</span>
                                    @else
                                        <span class="status-pill status-waiting_verification">Level belum mencukupi</span>
                                    @endif
                                @else
                                    <span class="status-pill status-waiting_verification">Login untuk cek benefit</span>
                                @endauth
                            @else
                                <span class="status-pill status-paid">Untuk semua customer</span>
                            @endif

                            <p class="promo-period">
                                {{ $promotion->start_date?->format('d M Y') ?? '-' }}
                                sampai
                                {{ $promotion->end_date?->format('d M Y') ?? '-' }}
                            </p>
                        </article>
                    @empty
                        <article class="promotion-card reveal">
                            <span class="promo-tag">Promotion</span>
                            <h3>No active promotions yet</h3>
                            <p>Promotions will appear after they are added by admin.</p>                        </article>
                    @endforelse
                </div>

                <div class="pagination-wrap">
                    {{ $promotions->links() }}
                </div>
            </div>
        </section>
    </main>
@endsection