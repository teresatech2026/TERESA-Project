<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\User;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Show the report form for a specific user (Buyer reports Farmer, or vice versa).
     */
    public function create(User $user)
    {
        abort_unless(
            (auth()->user()->role === 'farmer' && $user->role === 'buyer') ||
            (auth()->user()->role === 'buyer' && $user->role === 'farmer'),
            403
        );

        return view('reports.create', ['reportedUser' => $user]);
    }

    /**
     * Submit a new report.
     */
    public function store(Request $request, User $user)
    {
        abort_unless(
            (auth()->user()->role === 'farmer' && $user->role === 'buyer') ||
            (auth()->user()->role === 'buyer' && $user->role === 'farmer'),
            403
        );

        $request->validate([
            'reason' => 'required|string|max:100',
            'details' => 'nullable|string|max:1000',
            'related_order_id' => 'nullable|exists:orders,id',
        ]);

        Report::create([
            'reporter_id' => auth()->id(),
            'reported_user_id' => $user->id,
            'related_order_id' => $request->related_order_id,
            'reason' => $request->reason,
            'details' => $request->details,
        ]);

        return redirect()->route('messages.show', $user)->with('success', 'Report submitted. Our team will review it.');
    }
}