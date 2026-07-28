<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MessageController extends Controller
{
    /**
     * List all conversations for the logged-in user (grouped by the other person).
     */
    public function index()
    {
        $userId = auth()->id();

        // Find every distinct "other person" this user has exchanged messages with
        $partnerIds = Message::where('sender_id', $userId)
            ->orWhere('receiver_id', $userId)
            ->get()
            ->map(fn ($m) => $m->sender_id === $userId ? $m->receiver_id : $m->sender_id)
            ->unique();

        $conversations = User::whereIn('id', $partnerIds)
            ->get()
            ->map(function ($partner) use ($userId) {
                $lastMessage = Message::where(function ($q) use ($userId, $partner) {
                        $q->where('sender_id', $userId)->where('receiver_id', $partner->id);
                    })->orWhere(function ($q) use ($userId, $partner) {
                        $q->where('sender_id', $partner->id)->where('receiver_id', $userId);
                    })->latest()->first();

                $unreadCount = Message::where('sender_id', $partner->id)
                    ->where('receiver_id', $userId)
                    ->where('is_read', false)
                    ->count();

                return (object) [
                    'partner' => $partner,
                    'last_message' => $lastMessage,
                    'unread_count' => $unreadCount,
                ];
            })
            ->sortByDesc(fn ($c) => $c->last_message?->created_at)
            ->values();

        return view('messages.index', compact('conversations'));
    }

    /**
     * Show the full thread with one specific person, and mark their messages as read.
     */
    public function show(User $user)
    {
        $userId = auth()->id();

        // Only allow Buyer<->Farmer conversations, matching the spec
        abort_unless(
            (auth()->user()->role === 'farmer' && $user->role === 'buyer') ||
            (auth()->user()->role === 'buyer' && $user->role === 'farmer'),
            403
        );

        $messages = Message::where(function ($q) use ($userId, $user) {
                $q->where('sender_id', $userId)->where('receiver_id', $user->id);
            })->orWhere(function ($q) use ($userId, $user) {
                $q->where('sender_id', $user->id)->where('receiver_id', $userId);
            })->orderBy('created_at')->get();

        // Mark incoming messages as read
        Message::where('sender_id', $user->id)
            ->where('receiver_id', $userId)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return view('messages.show', ['partner' => $user, 'messages' => $messages]);
    }

    /**
     * Send a new message to a specific person.
     */
    public function store(Request $request, User $user)
    {
        abort_unless(
            (auth()->user()->role === 'farmer' && $user->role === 'buyer') ||
            (auth()->user()->role === 'buyer' && $user->role === 'farmer'),
            403
        );

        $request->validate([
            'message_text' => 'required|string|max:2000',
        ]);

        Message::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $user->id,
            'related_product_id' => $request->input('related_product_id'),
            'message_text' => $request->message_text,
        ]);

        return back();
    }
}