<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\Bid;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class BidController extends Controller
{
    /**
     * Determine whether a product is sold by a whole-number ("piece") unit.
     */
    private function isPieceUnit(Product $product): bool
    {
        return in_array(
            strtolower(trim($product->unit_of_measurement)),
            ['piece', 'pieces', 'pc', 'pcs']
        );
    }

    /**
     * Submit a new bid (offer) on a product.
     */
    public function store(Request $request, Product $product)
    {
        $isPieceUnit = $this->isPieceUnit($product);

        $request->validate([
            'quantity' => [
                'required',
                'numeric',
                'min:' . ($isPieceUnit ? 1 : 0.01),
                'max:' . $product->available_quantity,
                Rule::when($isPieceUnit, ['integer']),
            ],
            'offered_price' => 'required|numeric|min:0.01|lt:' . $product->selling_price,
            'message' => 'nullable|string|max:500',
        ], [
            'quantity.max' => 'You cannot bid for more than the available stock.',
            'quantity.integer' => 'This product is sold by the piece, so quantity must be a whole number.',
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
            ->with(['product.farmer', 'product.images', 'order'])
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

    /**
     * Show the checkout page for an accepted bid, where the buyer
     * chooses pickup/delivery before the order is actually created.
     */
    public function checkout(Bid $bid)
    {
        abort_unless($bid->buyer_id === auth()->user()->buyer->id, 403);
        abort_unless($bid->status === 'accepted', 403, 'This offer has not been accepted yet.');
        abort_if($bid->order_id, 403, 'This offer has already been checked out.');

        $bid->load('product.farmer');

        return view('buyer.bids.checkout', compact('bid'));
    }

    /**
     * Complete the checkout for an accepted bid — creates the real
     * Order and OrderItem using the negotiated quantity and price,
     * and reserves stock at this point.
     */
    public function completeCheckout(Request $request, Bid $bid)
    {
        abort_unless($bid->buyer_id === auth()->user()->buyer->id, 403);
        abort_unless($bid->status === 'accepted', 403, 'This offer has not been accepted yet.');
        abort_if($bid->order_id, 403, 'This offer has already been checked out.');

        $request->validate([
            'delivery_option' => 'required|in:pickup,delivery',
            'delivery_address' => 'required_if:delivery_option,delivery|nullable|string|max:500',
        ]);

        abort_if($bid->quantity > $bid->product->available_quantity, 422, 'Not enough stock left to complete this order.');

        $order = DB::transaction(function () use ($bid, $request) {
            $order = Order::create([
                'buyer_id' => $bid->buyer_id,
                'farmer_id' => $bid->product->farmer_id,
                'status' => 'pending',
                'delivery_option' => $request->delivery_option,
                'delivery_address' => $request->delivery_option === 'delivery' ? $request->delivery_address : null,
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

            $bid->update(['order_id' => $order->id]);

            \App\Models\Notification::notify(
                $order->farmer->user_id,
                'new_order',
                'Negotiated Order Confirmed',
                "{$bid->buyer->full_name} completed checkout for the negotiated order (#{$order->id}).",
                route('farmer.orders.show', $order)
            );

            return $order;
        });

        return redirect()->route('orders.show', $order)->with('success', 'Order placed successfully!');
    }
}