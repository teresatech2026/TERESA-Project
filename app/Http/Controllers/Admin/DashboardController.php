<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Advisory;
use App\Models\Order;
use App\Models\Product;
use App\Models\Report;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Quick stats
        $stats = [
            'farmers'        => User::where('role', 'farmer')->count(),
            'buyers'         => User::where('role', 'buyer')->count(),
            'activeListings' => Product::where('status', 'active')->count(),
            'ordersThisMonth'=> Order::whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])->count(),
        ];

        // 2. Needs attention
        $pendingReportsCount = Report::where('status', 'pending')->count();

        $pendingReports = Report::with(['reporter', 'reportedUser'])
            ->where('status', 'pending')
            ->latest()
            ->take(3)
            ->get();

        $deactivatedCount = User::where('is_active', false)->count();

        // 4. Recent activity
        $latestAdvisories = Advisory::latest('date_published')
            ->take(3)
            ->get();

        $newestFarmers = User::with('farmer')
            ->where('role', 'farmer')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'stats',
            'pendingReportsCount',
            'pendingReports',
            'deactivatedCount',
            'latestAdvisories',
            'newestFarmers'
        ));
    }
}