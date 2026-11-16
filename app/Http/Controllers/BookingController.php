<?php

namespace App\Http\Controllers;

use App\Models\Booking;

class BookingController extends Controller
{
    public function myBookings()
    {
        $bookings = Booking::with(['treatment', 'payment', 'reviews'])
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('bookings.my-bookings', compact('bookings'));
    }
}