<?php

namespace App\Http\Controllers;

use App\Models\ChatMessage;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    /**
     * Show chat for a specific report (consultation).
     */
    public function show(Report $report)
    {
        $user = Auth::user();

        // Only allow the reporter or the handler to access the chat
        if ($user->id !== $report->reported_by && $user->id !== $report->handled_by) {
            abort(403, 'Anda tidak memiliki akses ke chat ini.');
        }

        // Mark unread messages from the OTHER party as read, then destroy them
        $unreadMessages = ChatMessage::where('report_id', $report->id)
            ->where('sender_id', '!=', $user->id)
            ->where('is_destroyed', false)
            ->whereNull('read_at')
            ->get();

        foreach ($unreadMessages as $msg) {
            $msg->update(['read_at' => now()]);
        }

        // Get all visible messages
        $messages = $report->chatMessages()->with('sender')->get();

        $report->load(['reporter', 'handler']);

        $chatMessages = $messages->map(function ($msg) use ($user) {
            return [
                'id' => $msg->id,
                'message' => $msg->message,
                'sender_name' => $msg->sender->name,
                'is_mine' => $msg->sender_id === $user->id,
                'time' => $msg->created_at->format('H:i'),
                'date' => $msg->created_at->format('d M Y'),
            ];
        });

        return view('chat.index', compact('report', 'chatMessages', 'user'));
    }

    /**
     * Send a chat message.
     */
    public function send(Request $request, Report $report)
    {
        $user = Auth::user();

        if ($user->id !== $report->reported_by && $user->id !== $report->handled_by) {
            abort(403);
        }

        $request->validate([
            'message' => 'required|string|max:2000',
        ]);

        ChatMessage::create([
            'report_id' => $report->id,
            'sender_id' => $user->id,
            'message' => $request->message,
        ]);

        return back()->with('success', 'Pesan terkirim.');
    }

    /**
     * Get new messages (for polling/AJAX).
     */
    public function poll(Report $report)
    {
        $user = Auth::user();

        if ($user->id !== $report->reported_by && $user->id !== $report->handled_by) {
            abort(403);
        }

        // Mark unread messages as read
        $unread = ChatMessage::where('report_id', $report->id)
            ->where('sender_id', '!=', $user->id)
            ->where('is_destroyed', false)
            ->whereNull('read_at')
            ->get();

        foreach ($unread as $msg) {
            $msg->update(['read_at' => now()]);
        }

        // Get visible messages
        $messages = $report->chatMessages()->with('sender')->get();

        return response()->json([
            'messages' => $messages->map(function ($msg) use ($user) {
                return [
                    'id' => $msg->id,
                    'message' => $msg->message,
                    'sender_name' => $msg->sender->name,
                    'is_mine' => $msg->sender_id === $user->id,
                    'time' => $msg->created_at->format('H:i'),
                    'date' => $msg->created_at->format('d M Y'),
                ];
            }),
        ]);
    }
}
