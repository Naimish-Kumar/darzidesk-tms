<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Get in-app notifications for authenticated user
     */
    public function index(Request $request)
    {
        $user = $request->user();

        $notifications = Notification::where('user_id', $user->id)
            ->orWhere(function($q) use ($user) {
                if ($user->parent_id && $user->parent_id > 0) {
                    $q->where('parent_id', $user->parent_id);
                }
            })
            ->orderBy('id', 'desc')
            ->get()
            ->map(function ($n) {
                return [
                    'id' => $n->id,
                    'type' => $n->type ?? 'general',
                    'module' => $n->module ?? 'system',
                    'subject' => $n->subject ?? 'Notification',
                    'message' => $n->message ?? '',
                    'is_read' => (bool) ($n->is_read ?? false),
                    'created_at' => $n->created_at ? $n->created_at->format('Y-m-d H:i') : '',
                ];
            });

        $unreadCount = $notifications->where('is_read', false)->count();

        return response()->json([
            'success' => true,
            'unread_count' => $unreadCount,
            'notifications' => $notifications,
        ]);
    }

    /**
     * Mark all notifications as read
     */
    public function markAllAsRead(Request $request)
    {
        $user = $request->user();

        Notification::where('user_id', $user->id)
            ->orWhere(function($q) use ($user) {
                if ($user->parent_id && $user->parent_id > 0) {
                    $q->where('parent_id', $user->parent_id);
                }
            })->update(['is_read' => true]);

        return response()->json(['success' => true, 'message' => 'All notifications marked as read']);
    }

    /**
     * Mark single notification as read
     */
    public function markAsRead(Request $request, $id)
    {
        $user = $request->user();

        $notification = Notification::where('id', $id)->first();
        if ($notification) {
            $notification->is_read = true;
            $notification->save();
        }

        return response()->json(['success' => true, 'message' => 'Notification marked as read']);
    }

    /**
     * Helper method to send in-app notification
     */
    public static function createNotification($userId, $type, $subject, $message, $parentId = 0)
    {
        return Notification::create([
            'user_id' => $userId,
            'type' => $type,
            'subject' => $subject,
            'message' => $message,
            'module' => $type,
            'is_read' => false,
            'parent_id' => $parentId,
        ]);
    }
}
