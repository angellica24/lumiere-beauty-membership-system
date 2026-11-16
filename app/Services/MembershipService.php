<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\MembershipLevel;
use App\Models\PointTransaction;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class MembershipService
{
    public function getActivePoints(int $userId): int
    {
        return (int) PointTransaction::where('user_id', $userId)
            ->where(function ($query) {
                $query->whereNull('expired_at')
                    ->orWhere('expired_at', '>=', now()->toDateString());
            })
            ->sum('points');
    }

    public function calculatePointsFromPrice(float $price): int
    {
        return max(1, (int) floor($price / 10000));
    }

    public function syncUserMembership(int $userId): void
    {
        $user = User::findOrFail($userId);
        $activePoints = $this->getActivePoints($userId);

        $membershipLevel = MembershipLevel::where('min_points', '<=', $activePoints)
            ->orderByDesc('min_points')
            ->first();

        $user->update([
            'total_points' => $activePoints,
            'membership_level_id' => $membershipLevel?->id ?? 1,
        ]);
    }

    public function awardPointsForBooking(int $bookingId): int
    {
        return DB::transaction(function () use ($bookingId) {
            $booking = Booking::with(['user', 'payment'])->findOrFail($bookingId);

            if ($booking->payment_status !== 'paid') {
                return 0;
            }

            $alreadyAwarded = PointTransaction::where('booking_id', $booking->id)
                ->where('transaction_type', 'earn')
                ->exists();

            if ($alreadyAwarded) {
                return 0;
            }

            $points = $this->calculatePointsFromPrice((float) $booking->total_price);

            PointTransaction::create([
                'user_id' => $booking->user_id,
                'booking_id' => $booking->id,
                'points' => $points,
                'transaction_type' => 'earn',
                'description' => 'Poin dari booking ' . $booking->booking_code,
                'expired_at' => now()->addYear()->toDateString(),
                'created_at' => now(),
            ]);

            $this->syncUserMembership($booking->user_id);

            return $points;
        });
    }
}