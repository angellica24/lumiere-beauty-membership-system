<?php

namespace App\Http\Controllers;

use App\Models\PointTransaction;
use App\Services\MembershipService;

class PointController extends Controller
{
    public function index(MembershipService $membershipService)
    {
        $user = auth()->user()->load('membershipLevel');

        $membershipService->syncUserMembership($user->id);

        $user->refresh()->load('membershipLevel');

        $pointTransactions = PointTransaction::with('booking')
            ->where('user_id', $user->id)
            ->latest('created_at')
            ->paginate(10);

        return view('points.index', compact('user', 'pointTransactions'));
    }
}