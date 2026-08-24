<?php

namespace App\Http\Controllers\Farmer;

use App\Http\Controllers\Controller;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    public function index()
    {
        $farmer = auth()->user()->farmer;

        // Revenue and orders over the last 6 months, from THIS farmer's orders only
        $monthlyRevenue = OrderItem::select(
                DB::raw("TO_CHAR(orders.created_at, 'YYYY-MM') as month"),
                DB::raw('SUM(order_items.subtotal) as total_revenue')
            )
            ->join('orders', 'orders.id', '=', 'order_items.order_id')
            ->where('orders.farmer_id', $farmer->id)
            ->where('orders.created_at', '>=', now()->subMonths(6))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Best-selling products (by revenue)
        $topProducts = OrderItem::select('products.product_name', DB::raw('SUM(order_items.quantity) as total_qty'), DB::raw('SUM(order_items.subtotal) as total_revenue'))
            ->join('orders', 'orders.id', '=', 'order_items.order_id')
            ->join('products', 'products.id', '=', 'order_items.product_id')
            ->where('orders.farmer_id', $farmer->id)
            ->groupBy('products.id', 'products.product_name')
            ->orderByDesc('total_revenue')
            ->limit(5)
            ->get();

        // Order status breakdown
        $statusBreakdown = $farmer->orders()
            ->select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get();

        // Summary stats
        $stats = [
            'total_revenue' => $farmer->orders()->where('status', 'completed')->join('order_items', 'orders.id', '=', 'order_items.order_id')->sum('order_items.subtotal'),
            'total_orders' => $farmer->orders()->count(),
            'completed_orders' => $farmer->completed_orders,
            'active_products' => $farmer->products()->where('status', 'active')->count(),
            'overall_rating' => $farmer->overall_rating,
            'total_reviews' => $farmer->total_reviews,
        ];

        return view('farmer.analytics.index', compact('monthlyRevenue', 'topProducts', 'statusBreakdown', 'stats'));
    }
}