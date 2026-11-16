<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Services\MembershipService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $query = Booking::with(['user', 'treatment', 'payment']);

        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }

        if ($request->filled('booking_status')) {
            $query->where('booking_status', $request->booking_status);
        }

        if ($request->filled('treatment_status')) {
            $query->where('treatment_status', $request->treatment_status);
        }

        if ($request->filled('search')) {
            $query->where(function ($subQuery) use ($request) {
                $subQuery->where('booking_code', 'like', '%' . $request->search . '%')
                    ->orWhereHas('user', function ($userQuery) use ($request) {
                        $userQuery->where('name', 'like', '%' . $request->search . '%')
                            ->orWhere('email', 'like', '%' . $request->search . '%');
                    })
                    ->orWhereHas('treatment', function ($treatmentQuery) use ($request) {
                        $treatmentQuery->where('treatment_name', 'like', '%' . $request->search . '%');
                    });
            });
        }

        $bookings = $query->latest()->paginate(10)->withQueryString();

        return view('admin.bookings.index', compact('bookings'));
    }

    public function updateStatus(Request $request, Booking $booking, MembershipService $membershipService)
    {
        $data = $request->validate([
            'payment_status' => ['required', 'in:unpaid,waiting_verification,paid,failed,refunded'],
            'booking_status' => ['required', 'in:pending,confirmed,cancelled'],
            'treatment_status' => ['required', 'in:not_started,scheduled,completed,cancelled'],
        ]);

        DB::transaction(function () use ($booking, $data, $membershipService) {
            if ($data['payment_status'] === 'paid') {
                if ($data['booking_status'] === 'pending') {
                    $data['booking_status'] = 'confirmed';
                }

                if ($data['treatment_status'] === 'not_started') {
                    $data['treatment_status'] = 'scheduled';
                }
            }

            if (in_array($data['payment_status'], ['failed', 'refunded'], true)) {
                $data['booking_status'] = 'cancelled';
                $data['treatment_status'] = 'cancelled';
            }

            $booking->update($data);

            if ($booking->payment) {
                $booking->payment->update([
                    'payment_status' => $data['payment_status'],
                    'receipt_code' => $data['payment_status'] === 'paid'
                        ? ($booking->payment->receipt_code ?? $this->generateReceiptCode())
                        : $booking->payment->receipt_code,
                    'paid_at' => $data['payment_status'] === 'paid'
                        ? ($booking->payment->paid_at ?? now())
                        : null,
                    'confirmed_at' => $data['payment_status'] === 'paid'
                        ? now()
                        : null,
                ]);
            }

            if ($data['payment_status'] === 'paid') {
                $membershipService->awardPointsForBooking($booking->id);
            }
        });

        return redirect()->route('admin.bookings.index')
            ->with('success', 'Status booking berhasil diperbarui.');
    }

    private function generateReceiptCode(): string
    {
        return 'RCPT-' . now()->format('YmdHis') . '-' . random_int(1000, 9999);
    }
}