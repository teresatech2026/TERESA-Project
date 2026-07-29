<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Show the checkout review page (grouped by farmer).
     */
    public function checkout()
    {
        $buyer = auth()->user()->buyer;

        $cartItems = $buyer->cartItems()->with(['product.farmer'])->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        // Group cart items by farmer, since each farmer becomes a separate order
        $groupedByFarmer = $cartItems->groupBy(fn ($item) => $item->product->farmer_id);

        return view('buyer.orders.checkout', compact('groupedByFarmer'));
    }

    /**
     * Place the order(s) — one order per farmer represented in the cart.
     */
    public function store(Request $request)
    {
        $request->validate([
            'delivery_option' => 'required|in:pickup,delivery',
            'delivery_address' => 'required_if:delivery_option,delivery|nullable|string|max:500',
        ]);

        $buyer = auth()->user()->buyer;
        $cartItems = $buyer->cartItems()->with('product')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $groupedByFarmer = $cartItems->groupBy(fn ($item) => $item->product->farmer_id);

        DB::transaction(function () use ($groupedByFarmer, $buyer, $request) {
            foreach ($groupedByFarmer as $farmerId => $items) {
                $orderTotal = $items->sum(fn ($item) => $item->quantity * $item->product->selling_price);

                $order = Order::create([
                    'buyer_id' => $buyer->id,
                    'farmer_id' => $farmerId,
                    'status' => 'pending',
                    'delivery_option' => $request->delivery_option,
                    'delivery_address' => $request->delivery_option === 'delivery' ? $request->delivery_address : null,
                    'total_amount' => $orderTotal,
                ]);

                foreach ($items as $item) {
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $item->product_id,
                        'product_name_snapshot' => $item->product->product_name,
                        'quantity' => $item->quantity,
                        'unit_price' => $item->product->selling_price,
                        'subtotal' => $item->quantity * $item->product->selling_price,
                    ]);

                    // Reduce available stock
                    $item->product->decrement('available_quantity', $item->quantity);
                }
            }

            // Clear the cart now that orders are placed
            $buyer->cartItems()->delete();
        });

        return redirect()->route('orders.index')->with('success', 'Order placed successfully!');
    }

    /**
     * Show the buyer's order history.
     */
    public function index()
    {
        $orders = auth()->user()->buyer->orders()
            ->with(['items', 'farmer'])
            ->latest()
            ->get();

        return view('buyer.orders.index', compact('orders'));
    }

    /**
     * Show a single order's details.
     */
    public function show(Order $order)
    {
        abort_unless($order->buyer_id === auth()->user()->buyer->id, 403);

        $order->load(['items', 'farmer', 'review']);

        return view('buyer.orders.show', compact('order'));
    }
}