<?php

namespace App\Http\Controllers;

use App\Models\Booking;

class ProfileController extends Controller
{
    public function index()
    {
        $user = auth()->user()->load('membershipLevel');

        $totalBookings = Booking::where('user_id', $user->id)->count();

        $paidBookings = Booking::where('user_id', $user->id)
            ->where('payment_status', 'paid')
            ->count();

        $completedTreatments = Booking::where('user_id', $user->id)
            ->where('treatment_status', 'completed')
            ->count();

        return view('profile.index', compact(
            'user',
            'totalBookings',
            'paidBookings',
            'completedTreatments'
        ));
    }
}