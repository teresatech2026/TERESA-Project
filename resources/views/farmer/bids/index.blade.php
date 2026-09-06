<?php

namespace App\Http\Controllers\Farmer;

use App\Http\Controllers\Controller;
use App\Models\Bid;
use Illuminate\Http\Request;

class BidController extends Controller
{
    /**
     * List all bids on the farmer's products.
     */
    public function index(Request $request)
    {
        $status = $request->query('status', 'pending');
        $farmer = auth()->user()->farmer;

        $bids = Bid::whereHas('product', fn ($q) => $q->where('farmer_id', $farmer->id))
            ->when($status !== 'all', fn ($q) => $q->where('status', $status))
            ->with(['product', 'buyer', 'order'])
            ->latest()
            ->get();

        return view('farmer.bids.index', compact('bids', 'status'));
    }

    /**
     * Accept a bid — marks it accepted. The buyer completes checkout
     * afterward (choosing pickup/delivery), which is what actually
     * creates the Order and reserves stock.
     */
    public function accept(Bid $bid)
    {
        abort_unless($bid->product->farmer_id === auth()->user()->farmer->id, 403);
        abort_unless($bid->status === 'pending', 403, 'This offer is no longer pending.');
        abort_if($bid->quantity > $bid->product->available_quantity, 422, 'Not enough stock left to accept this offer.');

        $bid->update(['status' => 'accepted']);

        \App\Models\Notification::notify(
            $bid->buyer->user_id,
            'bid_accepted',
            'Your Offer Was Accepted!',
            "Your offer for {$bid->product->product_name} was accepted. Complete your order to finish.",
            route('bids.checkout', $bid)
        );

        return back()->with('success', 'Offer accepted! Waiting for the buyer to complete the order.');
    }

    /**
     * Reject a bid.
     */
    public function reject(Bid $bid)
    {
        abort_unless($bid->product->farmer_id === auth()->user()->farmer->id, 403);
        abort_unless($bid->status === 'pending', 403, 'This offer is no longer pending.');

        $bid->update(['status' => 'rejected']);

        \App\Models\Notification::notify(
            $bid->buyer->user_id,
            'bid_rejected',
            'Your Offer Was Declined',
            "Your offer for {$bid->product->product_name} was declined by the farmer.",
            route('marketplace.show', $bid->product)
        );

        return back()->with('success', 'Offer rejected.');
    }
}