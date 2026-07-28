<?php

namespace App\Http\Controllers\Farmer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Show all orders belonging to the logged-in farmer.
     */
    public function index()
    {
        $orders = auth()->user()->farmer->orders()
            ->with(['items', 'buyer'])
            ->latest()
            ->get();

        return view('farmer.orders.index', compact('orders'));
    }

    /**
     * Show a single order's details.
     */
    public function show(Order $order)
    {
        abort_unless($order->farmer_id === auth()->user()->farmer->id, 403);

        $order->load(['items', 'buyer']);

        return view('farmer.orders.show', compact('order'));
    }

    /**
     * Update the status of an order (Farmer moves it through the pipeline).
     */
    public function updateStatus(Request $request, Order $order)
    {
        abort_unless($order->farmer_id === auth()->user()->farmer->id, 403);

        $request->validate([
            'status' => 'required|in:confirmed,preparing,ready_for_pickup,out_for_delivery,completed,cancelled',
        ]);

        $order->update(['status' => $request->status]);

        // If the order is now completed, bump the farmer's completed_orders count
        if ($request->status === 'completed') {
            $order->farmer->increment('completed_orders');
        }

        return back()->with('success', 'Order status updated.');
    }
}