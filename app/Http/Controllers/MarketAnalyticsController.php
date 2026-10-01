<?php

namespace App\Http\Controllers;

use App\Models\Advisory;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Carbon;
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

        // System-generated interpretation of the monthly trend (rule-based, uses only TERESA data)
        $trendInsights = $this->interpretMonthlyTrend($monthlyTrend);

        // Marketplace statistics (simple counts)
        $stats = [
            'total_products' => Product::where('status', 'active')->count(),
            'total_farmers' => \App\Models\Farmer::count(),
            'total_orders' => \App\Models\Order::count(),
            'completed_orders' => \App\Models\Order::where('status', 'completed')->count(),
        ];

        $advisories = Advisory::latest('date_published')->get();

        return view('market-analytics.index', compact(
            'mostOrdered', 'highDemand', 'lowDemand', 'monthlyTrend', 'trendInsights', 'stats', 'advisories'
        ));
    }

    /**
     * Turn the monthly totals into plain-language sentences.
     * Every number comes from the orders stored in TERESA's database.
     */
    private function interpretMonthlyTrend($monthlyTrend): array
    {
        if ($monthlyTrend->isEmpty()) {
            return ['No orders have been recorded in the last 6 months yet, so there is no demand trend to interpret.'];
        }

        $insights   = [];
        $currentKey = now()->format('Y-m');

        $points = $monthlyTrend->map(fn ($row) => [
            'month' => $row->month,
            'label' => Carbon::createFromFormat('Y-m-d', $row->month . '-01')->format('F Y'),
            'qty'   => (float) $row->total_quantity,
        ]);

        // Full months only (the current month is still in progress)
        $complete = $points->filter(fn ($p) => $p['month'] !== $currentKey)->values();
        $current  = $points->firstWhere('month', $currentKey);

        if ($complete->count() === 1) {
            $only = $complete->first();
            $insights[] = "Only one full month of order data is available ({$only['label']}: {$this->fmt($only['qty'])} units ordered). More months are needed before a trend can be identified.";
        }

        if ($complete->count() >= 2) {
            // 1. Peak and lowest month
            $peak = $complete->sortByDesc('qty')->first();
            $low  = $complete->sortBy('qty')->first();
            $insights[] = "Demand peaked in {$peak['label']} with {$this->fmt($peak['qty'])} units ordered, while the lowest was {$low['label']} with {$this->fmt($low['qty'])} units.";

            // 2. Latest full month vs. the month before
            $last = $complete->last();
            $prev = $complete[$complete->count() - 2];

            if ($prev['qty'] == 0) {
                $change = "rose to {$this->fmt($last['qty'])} units, up from no orders in {$prev['label']}";
            } else {
                $pct = round((($last['qty'] - $prev['qty']) / $prev['qty']) * 100);
                if (abs($pct) < 5) {
                    $change = "stayed about the same as {$prev['label']} at {$this->fmt($last['qty'])} units";
                } elseif ($pct > 0) {
                    $change = "increased by {$pct}% compared to {$prev['label']} ({$this->fmt($prev['qty'])} → {$this->fmt($last['qty'])} units)";
                } else {
                    $change = "decreased by " . abs($pct) . "% compared to {$prev['label']} ({$this->fmt($prev['qty'])} → {$this->fmt($last['qty'])} units)";
                }
            }

            // 3. Top commodity in the latest full month
            $top = $this->topCommodityFor($last['month']);
            $leader = $top ? " The most ordered commodity that month was {$top->commodity_type} ({$this->fmt((float) $top->qty)} units)." : '';

            $insights[] = "In {$last['label']}, demand {$change}.{$leader}";

            // 4. Overall direction (needs at least 3 full months)
            if ($complete->count() >= 3) {
                $first = $complete->first();
                if ($first['qty'] > 0) {
                    $overall = round((($last['qty'] - $first['qty']) / $first['qty']) * 100);
                    if (abs($overall) < 10) {
                        $insights[] = "Overall, demand has been fairly stable from {$first['label']} to {$last['label']}.";
                    } elseif ($overall > 0) {
                        $insights[] = "Overall, demand is trending upward, growing {$overall}% from {$first['label']} to {$last['label']}.";
                    } else {
                        $insights[] = "Overall, demand is trending downward, falling " . abs($overall) . "% from {$first['label']} to {$last['label']}.";
                    }
                }
            }
        }

        // 5. Current month (still in progress)
        $monthName = now()->format('F Y');
        if ($current) {
            $insights[] = "As of " . now()->format('F j') . ", {$this->fmt($current['qty'])} units have been ordered in {$monthName}. This month is still in progress, so its figure is not yet complete.";
        } else {
            $insights[] = "No orders have been recorded yet for {$monthName}, which is still in progress.";
        }

        return $insights;
    }

    /**
     * The commodity with the highest total quantity ordered in a given month (YYYY-MM).
     */
    private function topCommodityFor(string $month)
    {
        return OrderItem::select('products.commodity_type', DB::raw('SUM(order_items.quantity) as qty'))
            ->join('products', 'products.id', '=', 'order_items.product_id')
            ->join('orders', 'orders.id', '=', 'order_items.order_id')
            ->whereRaw("TO_CHAR(orders.created_at, 'YYYY-MM') = ?", [$month])
            ->groupBy('products.commodity_type')
            ->orderByDesc('qty')
            ->first();
    }

    /**
     * Format a quantity: whole numbers without decimals, others with 2 decimals.
     */
    private function fmt(float $n): string
    {
        return $n == floor($n) ? number_format($n) : number_format($n, 2);
    }
}