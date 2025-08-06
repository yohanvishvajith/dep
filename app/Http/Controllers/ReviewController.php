<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Get a review for editing.
     */
    public function show($id)
    {
        $review = Review::where('id', $id)
            ->where('user_id', Auth::id())
            ->first();

        if (!$review) {
            return response()->json([
                'success' => false,
                'message' => 'Review not found or not authorized.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'review' => $review
        ]);
    }

    /**
     * Update the specified review in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'rating' => 'required|integer|between:1,5',
            'comment' => 'required|string|max:1000',
        ]);

        $review = Review::where('id', $id)
            ->where('user_id', Auth::id())
            ->first();

        if (!$review) {
            return response()->json([
                'success' => false,
                'message' => 'Review not found or not authorized.'
            ], 404);
        }

        $review->update([
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Review updated successfully!',
            'review' => $review
        ]);
    }

    /**
     * Store a newly created review in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'reservation_id' => 'required|exists:reservations,reservation_id',
            'rating' => 'required|integer|between:1,5',
            'comment' => 'required|string|max:1000',
        ]);

        $reservation = Reservation::where('reservation_id', $request->reservation_id)
            ->where('user_id', Auth::id())
            ->where('status', 'Completed') // Ensure the reservation is completed
            ->first();

        if (!$reservation) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid reservation or not authorized to review.'
            ], 403);
        }

        // Check if review already exists
        if ($reservation->review) {
            return response()->json([
                'success' => false,
                'message' => 'You have already reviewed this reservation.'
            ], 409);
        }

        $review = Review::create([
            'user_id' => Auth::id(),
            'vehicle_id' => $reservation->vehicle_id,
            'reservation_id' => $reservation->reservation_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'is_approved' => true, // Reviews are automatically approved
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Review submitted successfully!',
            'review' => $review
        ]);
    }
}
