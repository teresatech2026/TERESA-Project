<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * List all notifications for the logged-in user.
     */
    public function index()
    {
        $notifications = auth()->user()->notifications()->latest()->get();

        // Mark all as read once viewed
        auth()->user()->notifications()->where('is_read', false)->update(['is_read' => true]);

        return view('notifications.index', compact('notifications'));
    }

    /**
     * Redirect to wherever a notification points, then mark it read (in case clicked from a dropdown).
     */
    public function redirect(Notification $notification)
    {
        abort_unless($notification->user_id === auth()->id(), 403);

        $notification->update(['is_read' => true]);

        return redirect($notification->url ?? route('dashboard'));
    }
}