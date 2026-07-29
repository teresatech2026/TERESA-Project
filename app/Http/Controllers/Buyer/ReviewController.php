<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Store a review for a completed order.
     */
    public function store(Request $request, Order $order)
    {
        $buyer = auth()->user()->buyer;

        abort_unless($order->buyer_id === $buyer->id, 403);
        abort_unless($order->status === 'completed', 403, 'Only completed orders can be reviewed.');
        abort_if($order->review()->exists(), 403, 'This order has already been reviewed.');

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        Review::create([
            'order_id' => $order->id,
            'buyer_id' => $buyer->id,
            'farmer_id' => $order->farmer_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        // Recalculate the farmer's overall rating and review count
        $farmer = $order->farmer;
        $farmer->update([
            'total_reviews' => $farmer->reviews()->count(),
            'overall_rating' => $farmer->reviews()->avg('rating'),
        ]);

        return back()->with('success', 'Thank you for your review!');
    }
}