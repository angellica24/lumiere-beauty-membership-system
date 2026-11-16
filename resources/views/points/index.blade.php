@extends('layouts.app')

@section('title', 'My Points - Lumiere Beauty Clinic')

@section('content')
    <main>
        <section class="page-hero">
            <div class="container page-hero-content">
                <span class="eyebrow eyebrow-dark">Membership Points</span>
                <h1>My Points</h1>
                <p>Poin membership diperoleh setelah pembayaran booking diverifikasi admin.</p>
            </div>
        </section>

        <section class="section-block">
            <div class="container">
                <div class="membership-summary">
                    <article class="membership-card reveal">
                        <span class="member-badge {{ strtolower($user->membershipLevel->level_name ?? 'bronze') }}">
                            {{ $user->membershipLevel->level_name ?? 'Bronze' }}
                        </span>

                        <h3>Current Level</h3>
                        <p>{{ $user->membershipLevel->benefits ?? 'Benefit membership dasar.' }}</p>
                        <strong>{{ $user->total_points }} Points</strong>
                    </article>

                    <article class="membership-card reveal">
                        <span class="member-badge silver">Next Benefit</span>
                        <h3>Collect More Points</h3>
                        <p>Semakin banyak transaksi paid, semakin tinggi level membership yang dapat dicapai.</p>
                        <a href="{{ route('treatments.index') }}" class="btn btn-primary">Book Treatment</a>
                    </article>
                </div>

                <div class="table-card reveal">
                    <div class="table-header">
                        <div>
                            <h2>Riwayat Poin</h2>
                            <p>Catatan earn, redeem, adjustment, atau expired point.</p>
                        </div>
                    </div>

                    <div class="responsive-table">
                        <table>
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Tipe</th>
                                    <th>Poin</th>
                                    <th>Deskripsi</th>
                                    <th>Kedaluwarsa</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse($pointTransactions as $transaction)
                                    <tr>
                                        <td>{{ $transaction->created_at?->format('d M Y') }}</td>
                                        <td>{{ ucfirst($transaction->transaction_type) }}</td>
                                        <td>
                                            <strong>{{ $transaction->points }}</strong>
                                        </td>
                                        <td>{{ $transaction->description ?? '-' }}</td>
                                        <td>{{ $transaction->expired_at?->format('d M Y') ?? '-' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5">Belum ada riwayat poin.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="pagination-wrap">
                        {{ $pointTransactions->links() }}
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection