<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\Bid;
use App\Models\Product;
use Illuminate\Http\Request;

class BidController extends Controller
{
    /**
     * Submit a new bid (offer) on a product.
     */
    public function store(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'required|numeric|min:0.01|max:' . $product->available_quantity,
            'offered_price' => 'required|numeric|min:0.01|lt:' . $product->selling_price,
            'message' => 'nullable|string|max:500',
        ], [
            'quantity.max' => 'You cannot bid for more than the available stock.',
            'offered_price.lt' => 'Your offer must be lower than the listed price (₱' . number_format($product->selling_price, 2) . ').',
        ]);

        $bid = Bid::create([
            'product_id' => $product->id,
            'buyer_id' => auth()->user()->buyer->id,
            'quantity' => $request->quantity,
            'offered_price' => $request->offered_price,
            'message' => $request->message,
            'status' => 'pending',
        ]);

        \App\Models\Notification::notify(
            $product->farmer->user_id,
            'new_bid',
            'New Offer Received',
            auth()->user()->name . " offered ₱{$request->offered_price}/{$product->unit_of_measurement} for {$request->quantity} {$product->unit_of_measurement} of {$product->product_name}.",
            route('farmer.bids.index')
        );

        return back()->with('success', 'Your offer has been sent to the farmer!');
    }

    /**
     * List the buyer's own bids (My Offers).
     */
    public function index()
    {
        $bids = auth()->user()->buyer->bids()
            ->with(['product.farmer', 'product.images'])
            ->latest()
            ->get();

        return view('buyer.bids.index', compact('bids'));
    }

    /**
     * Cancel a pending bid.
     */
    public function cancel(Bid $bid)
    {
        abort_unless($bid->buyer_id === auth()->user()->buyer->id, 403);
        abort_unless($bid->status === 'pending', 403, 'Only pending offers can be cancelled.');

        $bid->update(['status' => 'cancelled']);

        return back()->with('success', 'Offer cancelled.');
    }
}