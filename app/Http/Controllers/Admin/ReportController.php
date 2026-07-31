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

    if (in_array($request->status, ['reviewed', 'dismissed'])) {
        \App\Models\Notification::notify(
            $report->reporter_id,
            'report_update',
            'Your Report Has Been ' . ucfirst($request->status),
            "Your report regarding {$report->reportedUser->name} has been {$request->status} by our team.",
            null
        );
    }

    return back()->with('success', 'Report status updated.');
}
}