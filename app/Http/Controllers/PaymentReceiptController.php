<?php

namespace App\Http\Controllers;

use App\Models\Booking;

class PaymentReceiptController extends Controller
{
    public function show(Booking $booking)
    {
        $booking->load(['user', 'treatment', 'payment']);

        if (auth()->user()->role !== 'admin' && $booking->user_id !== auth()->id()) {
            abort(403);
        }

        if (!$booking->payment || $booking->payment_status !== 'paid') {
            return redirect()->route('bookings.mine')
                ->with('error', 'Receipt hanya tersedia setelah pembayaran diverifikasi.');
        }

        return view('payments.receipt', compact('booking'));
    }
}