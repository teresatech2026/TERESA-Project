<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    public function index()
    {
        $buyer = auth()->user()->buyer;

        // Spending over the last 6 months
        $monthlySpending = OrderItem::select(
                DB::raw("TO_CHAR(orders.created_at, 'YYYY-MM') as month"),
                DB::raw('SUM(order_items.subtotal) as total_spent')
            )
            ->join('orders', 'orders.id', '=', 'order_items.order_id')
            ->where('orders.buyer_id', $buyer->id)
            ->where('orders.created_at', '>=', now()->subMonths(6))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Most purchased commodities
        $topPurchases = OrderItem::select('products.commodity_type', DB::raw('SUM(order_items.quantity) as total_qty'), DB::raw('SUM(order_items.subtotal) as total_spent'))
            ->join('orders', 'orders.id', '=', 'order_items.order_id')
            ->join('products', 'products.id', '=', 'order_items.product_id')
            ->where('orders.buyer_id', $buyer->id)
            ->groupBy('products.commodity_type')
            ->orderByDesc('total_spent')
            ->limit(5)
            ->get();

        // Order status breakdown
        $statusBreakdown = $buyer->orders()
            ->select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get();

        $stats = [
            'total_spent' => $buyer->orders()->join('order_items', 'orders.id', '=', 'order_items.order_id')->sum('order_items.subtotal'),
            'total_orders' => $buyer->orders()->count(),
            'completed_orders' => $buyer->orders()->where('status', 'completed')->count(),
            'pending_offers' => $buyer->bids()->where('status', 'pending')->count(),
        ];

        return view('buyer.analytics.index', compact('monthlySpending', 'topPurchases', 'statusBreakdown', 'stats'));
    }
}