@extends('layouts.app')

@section('title', 'My Bookings - Lumiere Beauty Clinic')

@section('content')
    <main>
        <section class="page-hero">
            <div class="container page-hero-content">
                <span class="eyebrow eyebrow-dark">Reservation History</span>
                <h1>My Bookings</h1>
                <p>Lihat status booking, pembayaran, treatment, dan receipt Anda.</p>
            </div>
        </section>

        <section class="section-block">
            <div class="container">
                <div class="table-card reveal">
                    <div class="table-header">
                        <div>
                            <h2>Riwayat Booking</h2>
                            <p>Booking terbaru akan muncul di bagian atas.</p>
                        </div>

                        <a href="{{ route('treatments.index') }}" class="btn btn-primary">
                            Booking Baru
                        </a>
                    </div>

                    <div class="responsive-table">
                        <table>
                            <thead>
                                <tr>
                                    <th>Kode</th>
                                    <th>Treatment</th>
                                    <th>Jadwal</th>
                                    <th>Total</th>
                                    <th>Pembayaran</th>
                                    <th>Booking</th>
                                    <th>Treatment</th>
                                    <th>Receipt</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse($bookings as $booking)
                                    <tr>
                                        <td>
                                            <strong>{{ $booking->booking_code }}</strong><br>
                                            <small>{{ $booking->created_at?->format('d M Y H:i') }}</small>
                                        </td>

                                        <td>
                                            {{ $booking->treatment->treatment_name ?? '-' }}
                                        </td>

                                        <td>
                                            {{ $booking->booking_date?->format('d M Y') }}<br>
                                            <small>{{ $booking->booking_time }}</small>
                                        </td>

                                        <td>
                                            Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                                        </td>

                                        <td>
                                            <span class="status-pill status-{{ $booking->payment_status }}">
                                                {{ ucfirst(str_replace('_', ' ', $booking->payment_status)) }}
                                            </span>
                                        </td>

                                        <td>
                                            <span class="status-pill">
                                                {{ ucfirst(str_replace('_', ' ', $booking->booking_status)) }}
                                            </span>
                                        </td>

                                        <td>
                                            <span class="status-pill">
                                                {{ ucfirst(str_replace('_', ' ', $booking->treatment_status)) }}
                                            </span>
                                        </td>

                                        <td>
                                            @if($booking->payment_status === 'paid')
                                                <a href="{{ route('payment.receipt', $booking) }}" class="btn btn-outline btn-small">
                                                    Lihat
                                                </a>
                                            @else
                                                -
                                            @endif
                                        </td>
                                    </tr>

                                    @if($booking->treatment_status === 'completed')
                                        @php
                                            $myReview = $booking->reviews
                                                ->where('user_id', auth()->id())
                                                ->first();
                                        @endphp

                                        <tr>
                                            <td colspan="8">
                                                <details class="review-details" {{ $myReview ? '' : '' }}>
                                                    <summary>
                                                        {{ $myReview ? 'Edit Review - ' . ($booking->treatment->treatment_name ?? 'Booking') : 'Review This Booking - ' . ($booking->treatment->treatment_name ?? 'Booking') }}
                                                    </summary>

                                                    <div class="review-box">
                                                        <div class="review-target">
                                                            <strong>Booking Code:</strong> {{ $booking->booking_code }} <br>
                                                            <strong>Treatment:</strong> {{ $booking->treatment->treatment_name ?? '-' }} <br>
                                                            <strong>Schedule:</strong>
                                                            {{ $booking->booking_date?->format('d M Y') }}
                                                            {{ $booking->booking_time }}
                                                        </div>

                                                        <form action="{{ route('reviews.store') }}" method="POST" class="auth-form">
                                                            @csrf

                                                            <input type="hidden" name="reviewable_type" value="booking">
                                                            <input type="hidden" name="reviewable_id" value="{{ $booking->id }}">

                                                            <div class="form-group">
                                                                <label>Rating</label>
                                                                <select name="rating" required>
                                                                    <option value="">Choose rating</option>

                                                                    @for($i = 1; $i <= 5; $i++)
                                                                        <option value="{{ $i }}" {{ $myReview && $myReview->rating == $i ? 'selected' : '' }}>
                                                                            {{ $i }} Star
                                                                        </option>
                                                                    @endfor
                                                                </select>
                                                            </div>

                                                            <div class="form-group">
                                                                <label>Comment</label>
                                                                <textarea name="comment" rows="3" placeholder="Write your experience">{{ $myReview->comment ?? '' }}</textarea>
                                                            </div>

                                                            <button type="submit" class="btn btn-primary">
                                                                {{ $myReview ? 'Update Review' : 'Submit Review' }}
                                                            </button>
                                                        </form>
                                                    </div>
                                                </details>
                                            </td>
                                        </tr>
                                    @endif
                                @empty
                                    <tr>
                                        <td colspan="8">Anda belum memiliki booking.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="pagination-wrap">
                        {{ $bookings->links() }}
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection