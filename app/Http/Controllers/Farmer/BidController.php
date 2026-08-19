<?php

namespace App\Http\Controllers\Farmer;

use App\Http\Controllers\Controller;
use App\Models\Bid;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
            ->with(['product', 'buyer'])
            ->latest()
            ->get();

        return view('farmer.bids.index', compact('bids', 'status'));
    }

    /**
     * Accept a bid — creates a real order at the negotiated price, decrements stock.
     */
    public function accept(Bid $bid)
    {
        abort_unless($bid->product->farmer_id === auth()->user()->farmer->id, 403);
        abort_unless($bid->status === 'pending', 403, 'This offer is no longer pending.');
        abort_if($bid->quantity > $bid->product->available_quantity, 422, 'Not enough stock left to accept this offer.');

        DB::transaction(function () use ($bid) {
            $order = Order::create([
                'buyer_id' => $bid->buyer_id,
                'farmer_id' => $bid->product->farmer_id,
                'status' => 'pending',
                'delivery_option' => 'pickup', // default; buyer/farmer can coordinate details via chat
                'total_amount' => $bid->quantity * $bid->offered_price,
            ]);

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $bid->product_id,
                'product_name_snapshot' => $bid->product->product_name . ' (negotiated price)',
                'quantity' => $bid->quantity,
                'unit_price' => $bid->offered_price,
                'subtotal' => $bid->quantity * $bid->offered_price,
            ]);

            $bid->product->decrement('available_quantity', $bid->quantity);

            $bid->update(['status' => 'accepted', 'order_id' => $order->id]);

            \App\Models\Notification::notify(
                $bid->buyer->user_id,
                'bid_accepted',
                'Your Offer Was Accepted!',
                "Your offer for {$bid->product->product_name} was accepted. An order has been created.",
                route('orders.show', $order)
            );
        });

        return back()->with('success', 'Offer accepted! An order has been created.');
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