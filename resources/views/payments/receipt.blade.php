@extends('layouts.app')

@section('title', 'Payment Receipt - Lumiere Beauty Clinic')

@section('content')
    <main>
        <section class="page-hero">
            <div class="container page-hero-content">
                <span class="eyebrow eyebrow-dark">Payment Receipt</span>
                <h1>Receipt Pembayaran</h1>
                <p>Bukti pembayaran treatment setelah diverifikasi oleh admin.</p>
            </div>
        </section>

        <section class="section-block">
            <div class="container">
                <div class="receipt-card reveal">
                    <div class="receipt-header">
                        <div>
                            <h2>Lumiere Beauty Clinic</h2>
                            <p>Official Payment Receipt</p>
                        </div>

                        <div>
                            <span class="status-pill status-paid">
                                {{ str_replace('_', ' ', $booking->payment_status) }}
                            </span>
                        </div>
                    </div>

                    <div class="receipt-grid">
                        <div>
                            <h3>Receipt Information</h3>
                            <p>
                                <strong>Receipt Code:</strong> {{ $booking->payment->receipt_code ?? '-' }}<br>
                                <strong>Booking Code:</strong> {{ $booking->booking_code }}<br>
                                <strong>Transaction Code:</strong> {{ $booking->payment->transaction_code ?? '-' }}
                            </p>
                        </div>

                        <div>
                            <h3>Customer</h3>
                            <p>
                                <strong>Nama:</strong> {{ $booking->user->name ?? '-' }}<br>
                                <strong>Email:</strong> {{ $booking->user->email ?? '-' }}<br>
                                <strong>Telepon:</strong> {{ $booking->user->phone ?? '-' }}
                            </p>
                        </div>

                        <div>
                            <h3>Treatment</h3>
                            <p>
                                <strong>Treatment:</strong> {{ $booking->treatment->treatment_name ?? '-' }}<br>
                                <strong>Tanggal:</strong> {{ $booking->booking_date?->format('d M Y') }}<br>
                                <strong>Jam:</strong> {{ $booking->booking_time }}
                            </p>
                        </div>

                        <div>
                            <h3>Payment</h3>
                            <p>
                                <strong>Metode:</strong> {{ $booking->payment ? str_replace('_', ' ', $booking->payment->payment_method) : '-' }}<br>
                                <strong>Payer:</strong> {{ $booking->payment->payer_name ?? '-' }}<br>
                                <strong>Reference:</strong> {{ $booking->payment->payment_reference ?? '-' }}<br>
                                <strong>Paid At:</strong> {{ $booking->payment?->paid_at?->format('d M Y H:i') ?? '-' }}
                            </p>
                        </div>
                    </div>

                    <div class="receipt-total">
                        <span>Total Payment</span>
                        <strong>Rp {{ number_format($booking->total_price, 0, ',', '.') }}</strong>
                    </div>

                    <div class="receipt-actions">
                        <a href="{{ route('bookings.mine') }}" class="btn btn-outline">Kembali</a>
                        <button onclick="window.print()" class="btn btn-primary">Print Receipt</button>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection