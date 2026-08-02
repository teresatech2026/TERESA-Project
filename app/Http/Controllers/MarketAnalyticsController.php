<?php

namespace App\Http\Controllers;

use App\Models\Advisory;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class MarketAnalyticsController extends Controller
{
    /**
     * Show the combined Market Analytics + Advisories page (read-only for everyone).
     */
    public function index()
    {
        // Most ordered commodities (by total quantity sold across all completed order items)
        $mostOrdered = OrderItem::select('products.commodity_type', DB::raw('SUM(order_items.quantity) as total_quantity'))
            ->join('products', 'products.id', '=', 'order_items.product_id')
            ->groupBy('products.commodity_type')
            ->orderByDesc('total_quantity')
            ->limit(5)
            ->get();

        // High demand: commodities with the most orders placed (order count, not quantity)
        $highDemand = OrderItem::select('products.commodity_type', DB::raw('COUNT(DISTINCT order_items.order_id) as order_count'))
            ->join('products', 'products.id', '=', 'order_items.product_id')
            ->groupBy('products.commodity_type')
            ->orderByDesc('order_count')
            ->limit(5)
            ->get();

        // Low demand: active products with zero orders ever
        $lowDemand = Product::where('status', 'active')
            ->whereDoesntHave('orderItems')
            ->limit(5)
            ->get();

        // Monthly demand trend (last 6 months, total quantity ordered per month)
        $monthlyTrend = OrderItem::select(
                DB::raw("TO_CHAR(orders.created_at, 'YYYY-MM') as month"),
                DB::raw('SUM(order_items.quantity) as total_quantity')
            )
            ->join('orders', 'orders.id', '=', 'order_items.order_id')
            ->where('orders.created_at', '>=', now()->subMonths(6))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Marketplace statistics (simple counts)
        $stats = [
            'total_products' => Product::where('status', 'active')->count(),
            'total_farmers' => \App\Models\Farmer::count(),
            'total_orders' => \App\Models\Order::count(),
            'completed_orders' => \App\Models\Order::where('status', 'completed')->count(),
        ];

        $advisories = Advisory::latest('date_published')->get();

        return view('market-analytics.index', compact(
            'mostOrdered', 'highDemand', 'lowDemand', 'monthlyTrend', 'stats', 'advisories'
        ));
    }
}