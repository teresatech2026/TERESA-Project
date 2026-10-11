<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * List all notifications for the logged-in user.
     * Order status updates are grouped into one entry per order.
     */
    public function index()
    {
        $all = auth()->user()->notifications()
            ->where('type', '!=', 'new_message')
            ->latest('created_at')
            ->get();

        // --- One entry per order: all "order_update" notifications that point to the same order ---
        $orderEntries = $all->where('type', 'order_update')
            ->groupBy(fn ($n) => $n->url ?? 'order-' . $n->id)
            ->map(function ($items) {
                $items = $items->sortBy('created_at')->values(); // oldest -> newest
                $latest = $items->last();

                // Pull the status text out of "Your order #28 is now: Ready For Pickup."
                $items->each(function ($n) {
                    preg_match('/now:\s*(.+?)\.?\s*$/', (string) $n->content, $m);
                    $n->setAttribute('status_label', $m[1] ?? 'Updated');
                });

                preg_match('/order #(\d+)/i', (string) $latest->content, $o);

                return (object) [
                    'kind'       => 'order',
                    'order_id'   => $o[1] ?? null,
                    'latest'     => $latest,
                    'updates'    => $items,
                    'has_unread' => $items->contains(fn ($n) => ! $n->is_read),
                    'created_at' => $latest->created_at,
                ];
            })
            ->values();

        // --- Everything else stays as a normal single notification ---
        $singleEntries = $all->where('type', '!=', 'order_update')
            ->map(fn ($n) => (object) [
                'kind'         => 'single',
                'notification' => $n,
                'has_unread'   => ! $n->is_read,
                'created_at'   => $n->created_at,
            ])
            ->values();

        $entries = $orderEntries->concat($singleEntries)
            ->sortByDesc('created_at')
            ->values();

        // Mark all as read once viewed (the entries above already captured the unread state)
        auth()->user()->notifications()->where('is_read', false)->update(['is_read' => true]);

        return view('notifications.index', compact('entries'));
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