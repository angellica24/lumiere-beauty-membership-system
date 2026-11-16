@extends('layouts.admin')

@section('title', 'Dashboard Admin - Lumiere Beauty Clinic')

@section('admin_content')
    <section class="section-block">
        <div class="container admin-page-shell">
            <div class="admin-toolbar reveal">
                <div>
                    <span class="eyebrow eyebrow-dark">Admin Panel</span>
                    <h1>Dashboard Admin</h1>
                    <p>Ringkasan data treatment, customer, booking, pembayaran, dan revenue.</p>
                </div>

                <div class="admin-toolbar-actions">
                    <a href="{{ route('admin.treatments.create') }}" class="btn btn-primary">Add Treatment</a>
                    <a href="{{ route('admin.bookings.index') }}" class="btn btn-outline">Booking Verification</a>
                    <a href="{{ route('admin.promotions.index') }}" class="btn btn-outline">Manage Promotions</a>
                </div>
            </div>

            <div class="admin-kpi-grid">
                <article class="admin-kpi-card reveal">
                    <h3>{{ $totalTreatments }}</h3>
                    <p>Total Treatment</p>
                </article>

                <article class="admin-kpi-card reveal">
                    <h3>{{ $totalActiveTreatments }}</h3>
                    <p>Treatment Aktif</p>
                </article>

                <article class="admin-kpi-card reveal">
                    <h3>{{ $totalCustomers }}</h3>
                    <p>Total Customer</p>
                </article>

                <article class="admin-kpi-card reveal">
                    <h3>{{ $totalBookings }}</h3>
                    <p>Total Booking</p>
                </article>

                <article class="admin-kpi-card reveal">
                    <h3>{{ $totalPendingBookings }}</h3>
                    <p>Booking Pending</p>
                </article>

                <article class="admin-kpi-card reveal">
                    <h3>{{ $totalWaitingPayments }}</h3>
                    <p>Waiting Verification</p>
                </article>

                <article class="admin-kpi-card reveal">
                    <h3>{{ $totalCompletedTreatments }}</h3>
                    <p>Treatment Selesai</p>
                </article>

                <article class="admin-kpi-card reveal">
                    <h3>Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
                    <p>Total Revenue</p>
                </article>
            </div>

            <div class="table-card reveal">
                <div class="table-header">
                    <div>
                        <h2>Booking Terbaru</h2>
                        <p>5 data booking terbaru customer.</p>
                    </div>
                </div>

                <div class="responsive-table">
                    <table>
                        <thead>
                            <tr>
                                <th>Kode</th>
                                <th>Customer</th>
                                <th>Treatment</th>
                                <th>Jadwal</th>
                                <th>Payment</th>
                                <th>Status Booking</th>
                                <th>Status Treatment</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($latestBookings as $booking)
                                <tr>
                                    <td>
                                        <strong>{{ $booking->booking_code }}</strong><br>
                                        <small>{{ $booking->created_at?->format('d M Y H:i') }}</small>
                                    </td>
                                    <td>
                                        {{ $booking->user->name ?? '-' }}<br>
                                        <small>{{ $booking->user->email ?? '-' }}</small>
                                    </td>
                                    <td>
                                        {{ $booking->treatment->treatment_name ?? '-' }}<br>
                                        <small>{{ $booking->treatment->category ?? '-' }}</small>
                                    </td>
                                    <td>
                                        {{ $booking->booking_date?->format('d M Y') }}<br>
                                        <small>{{ $booking->booking_time }}</small>
                                    </td>
                                    <td>
                                        <span class="status-pill status-{{ $booking->payment_status }}">
                                            {{ str_replace('_', ' ', $booking->payment_status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="status-pill">
                                            {{ str_replace('_', ' ', $booking->booking_status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="status-pill">
                                            {{ str_replace('_', ' ', $booking->treatment_status) }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7">Belum ada data booking.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection