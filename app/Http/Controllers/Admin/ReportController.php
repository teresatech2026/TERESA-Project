<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * List all reports, filterable by status.
     */
    public function index(Request $request)
    {
        $status = $request->query('status', 'pending');

        $reports = Report::with(['reporter', 'reportedUser', 'relatedOrder'])
            ->when($status !== 'all', fn ($q) => $q->where('status', $status))
            ->latest()
            ->get();

        return view('admin.reports.index', compact('reports', 'status'));
    }

    /**
     * Update a report's status after Admin review.
     */
    public function updateStatus(Request $request, Report $report)
    {
        $request->validate([
            'status' => 'required|in:pending,reviewed,dismissed',
        ]);

        $report->update(['status' => $request->status]);

        return back()->with('success', 'Report status updated.');
    }
}