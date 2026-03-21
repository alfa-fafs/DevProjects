<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;

class NotificationController extends Controller
{
    // Show all notifications
    public function index()
    {
        $notifications = Notification::where('user_id', auth()->id())
            ->latest()
            ->get();

        // Mark all as read when viewed
        Notification::where('user_id', auth()->id())
            ->where('is_read', false)
            ->update(['is_read' => true, 'read_at' => now()]);

        return view('notifications.index', compact('notifications'));
    }

    // Get unread count for nav badge
    public function unreadCount()
    {
        $count = Notification::where('user_id', auth()->id())
            ->where('is_read', false)
            ->count();

        return response()->json(['count' => $count]);
    }

    // Delete a notification
    public function destroy($id)
    {
        Notification::where('id', $id)
            ->where('user_id', auth()->id())
            ->delete();

        return back()->with('success', 'Notification removed');
    }
}