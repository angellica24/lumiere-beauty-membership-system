@extends('layouts.admin')

@section('title', 'Booking Management - Lumiere Beauty Clinic')

@section('admin_content')
    <section class="section-block">
        <div class="container admin-page-shell">
            <div class="admin-toolbar reveal">
                <div>
                    <span class="eyebrow eyebrow-dark">Booking Management</span>
                    <h1>Booking Management</h1>
                    <p>Verify payment, booking status, and customer treatment status.</p>                </div>
            </div>

            <div class="table-card reveal" style="margin-bottom: 24px;">
                <form action="{{ route('admin.bookings.index') }}" method="GET" class="admin-filter-grid">
                    <div class="form-group">
                        <label for="search">Cari Data</label>
                        <input
                            type="text"
                            id="search"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Kode booking, customer, treatment"
                        >
                    </div>

                    <div class="form-group">
                        <label for="payment_status">Payment Status</label>
                        <select name="payment_status" id="payment_status">
                            <option value="">All Payments</option>
                            @foreach(['unpaid', 'waiting_verification', 'paid', 'failed', 'refunded'] as $status)
                                <option value="{{ $status }}" {{ request('payment_status') === $status ? 'selected' : '' }}>
                                    {{ str_replace('_', ' ', $status) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="booking_status">Booking Status</label>
                        <select name="booking_status" id="booking_status">
                            <option value="">Semua Booking</option>
                            @foreach(['pending', 'confirmed', 'cancelled'] as $status)
                                <option value="{{ $status }}" {{ request('booking_status') === $status ? 'selected' : '' }}>
                                    {{ str_replace('_', ' ', $status) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="treatment_status">Treatment Status</label>
                        <select name="treatment_status" id="treatment_status">
                            <option value="">Semua Treatment</option>
                            @foreach(['not_started', 'scheduled', 'completed', 'cancelled'] as $status)
                                <option value="{{ $status }}" {{ request('treatment_status') === $status ? 'selected' : '' }}>
                                    {{ str_replace('_', ' ', $status) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="admin-filter-actions">
                        <button type="submit" class="btn btn-primary">Filter</button>
                        <a href="{{ route('admin.bookings.index') }}" class="btn btn-outline">Reset</a>
                    </div>
                </form>
            </div>

            <div class="booking-admin-list">
                @forelse($bookings as $booking)
                    <article class="booking-admin-card reveal">
                        <div class="booking-admin-grid">
                            <div class="booking-admin-info">
                                <div class="booking-admin-header">
                                    <div>
                                        <span class="promo-tag">Booking</span>
                                        <h2>{{ $booking->booking_code }}</h2>
                                        <p>{{ $booking->created_at?->format('d M Y H:i') }}</p>
                                    </div>

                                    <div class="booking-admin-badges">
                                        <span class="status-pill status-{{ $booking->payment_status }}">
                                            {{ str_replace('_', ' ', $booking->payment_status) }}
                                        </span>
                                        <span class="status-pill">
                                            {{ str_replace('_', ' ', $booking->booking_status) }}
                                        </span>
                                        <span class="status-pill">
                                            {{ str_replace('_', ' ', $booking->treatment_status) }}
                                        </span>
                                    </div>
                                </div>

                                <div class="booking-admin-meta">
                                    <div>
                                        <h4>Customer</h4>
                                        <p>
                                            {{ $booking->user->name ?? '-' }}<br>
                                            <small>{{ $booking->user->email ?? '-' }}</small>
                                        </p>
                                    </div>

                                    <div>
                                        <h4>Treatment</h4>
                                        <p>
                                            {{ $booking->treatment->treatment_name ?? '-' }}<br>
                                            <small>{{ $booking->treatment->category ?? '-' }}</small>
                                        </p>
                                    </div>

                                    <div>
                                        <h4>Jadwal</h4>
                                        <p>
                                            {{ $booking->booking_date?->format('d M Y') }}<br>
                                            <small>{{ $booking->booking_time }}</small>
                                        </p>
                                    </div>

                                    <div>
                                        <h4>Payment</h4>
                                        <p>
                                            Metode: {{ $booking->payment ? str_replace('_', ' ', $booking->payment->payment_method) : '-' }}<br>
                                            <small>Payer: {{ $booking->payment->payer_name ?? '-' }}</small>
                                        </p>
                                    </div>

                                    <div>
                                        <h4>Total</h4>
                                        <p><strong>Rp {{ number_format($booking->total_price, 0, ',', '.') }}</strong></p>
                                    </div>

                                    <div>
                                        <h4>Referensi</h4>
                                        <p>{{ $booking->payment->payment_reference ?? '-' }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="booking-status-box">
                                <h3>Update Status</h3>

                                <form action="{{ route('admin.bookings.update-status', $booking) }}" method="POST" class="booking-status-form">
                                    @csrf
                                    @method('PATCH')

                                    <div class="form-group">
                                        <label for="payment_status_{{ $booking->id }}">Payment</label>
                                        <select name="payment_status" id="payment_status_{{ $booking->id }}">
                                            @foreach(['unpaid', 'waiting_verification', 'paid', 'failed', 'refunded'] as $status)
                                                <option value="{{ $status }}" {{ $booking->payment_status === $status ? 'selected' : '' }}>
                                                    {{ str_replace('_', ' ', $status) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="booking_status_{{ $booking->id }}">Booking</label>
                                        <select name="booking_status" id="booking_status_{{ $booking->id }}">
                                            @foreach(['pending', 'confirmed', 'cancelled'] as $status)
                                                <option value="{{ $status }}" {{ $booking->booking_status === $status ? 'selected' : '' }}>
                                                    {{ str_replace('_', ' ', $status) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="treatment_status_{{ $booking->id }}">Treatment</label>
                                        <select name="treatment_status" id="treatment_status_{{ $booking->id }}">
                                            @foreach(['not_started', 'scheduled', 'completed', 'cancelled'] as $status)
                                                <option value="{{ $status }}" {{ $booking->treatment_status === $status ? 'selected' : '' }}>
                                                    {{ str_replace('_', ' ', $status) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="booking-status-actions">
                                        <button type="submit" class="btn btn-primary btn-block">Update Status</button>

                                        @if($booking->payment_status === 'paid')
                                            <a href="{{ route('payment.receipt', $booking) }}" target="_blank" class="btn btn-outline btn-block">
                                                Lihat Receipt
                                            </a>
                                        @endif
                                    </div>
                                </form>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="table-card reveal">
                        <p>Belum ada data booking.</p>
                    </div>
                @endforelse
            </div>

            <div class="pagination-wrap">
                {{ $bookings->links() }}
            </div>
        </div>
    </section>
@endsection