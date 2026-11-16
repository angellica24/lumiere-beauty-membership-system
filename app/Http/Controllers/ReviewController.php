<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Promotion;
use App\Models\Review;
use App\Models\Treatment;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'reviewable_type' => ['required', 'in:booking,treatment,promotion'],
            'reviewable_id' => ['required', 'integer'],
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['nullable', 'string', 'max:1000'],
        ]);

        $typeMap = [
            'booking' => Booking::class,
            'treatment' => Treatment::class,
            'promotion' => Promotion::class,
        ];

        $modelClass = $typeMap[$validated['reviewable_type']];

        $reviewable = $modelClass::findOrFail($validated['reviewable_id']);

        if ($reviewable instanceof Booking) {
            if ($reviewable->user_id !== auth()->id()) {
                abort(403, 'You are not allowed to review this booking.');
            }

            if ($reviewable->treatment_status !== 'completed') {
                return back()->with('error', 'Review can only be added after treatment is completed.');
            }
        }

        Review::updateOrCreate(
            [
                'user_id' => auth()->id(),
                'reviewable_id' => $reviewable->id,
                'reviewable_type' => $modelClass,
            ],
            [
                'rating' => $validated['rating'],
                'comment' => $validated['comment'] ?? null,
            ]
        );

        return back()->with('success', 'Review has been saved successfully.');
    }
}