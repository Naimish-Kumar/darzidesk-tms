<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\User;
use App\Services\FcmService;
use Illuminate\Http\Request;
use Carbon\Carbon;

class NotificationController extends Controller
{
    /**
     * Get in-app notifications for authenticated user
     */
    public function index(Request $request)
    {
        $user = $request->user();

        $notifications = Notification::where(function ($query) use ($user) {
            $query->where('user_id', $user->id);
            if ($user->parent_id && $user->parent_id > 0) {
                $query->orWhere(function ($sub) use ($user) {
                    $sub->where('parent_id', $user->parent_id)
                        ->where(function ($q2) {
                            $q2->whereNull('user_id')->orWhere('user_id', 0);
                        });
                });
            } else {
                $query->orWhere(function ($sub) {
                    $sub->whereNull('user_id')->orWhere('user_id', 0);
                });
            }
        })
        ->orderBy('id', 'desc')
        ->get()
        ->map(function ($n) {
            $createdAt = $n->created_at ? Carbon::parse($n->created_at) : null;
            $dateGroup = 'older';
            $timeFormatted = '';

            if ($createdAt) {
                $now = Carbon::now();
                if ($createdAt->isToday()) {
                    $dateGroup = 'today';
                    $timeFormatted = $createdAt->format('h:i A');
                } elseif ($createdAt->isYesterday()) {
                    $dateGroup = 'yesterday';
                    $timeFormatted = 'Yesterday';
                } elseif ($createdAt->greaterThanOrEqualTo($now->copy()->subDays(7))) {
                    $dateGroup = 'earlier_this_week';
                    $timeFormatted = $createdAt->format('D');
                } else {
                    $dateGroup = 'older';
                    $timeFormatted = $createdAt->format('M d');
                }
            }

            return [
                'id' => (int) $n->id,
                'type' => $n->type ?? 'general',
                'module' => $n->module ?? 'system',
                'title' => $n->subject ?? 'Notification',
                'subject' => $n->subject ?? 'Notification',
                'message' => $n->message ?? '',
                'is_read' => (bool) ($n->is_read ?? false),
                'created_at' => $createdAt ? $createdAt->format('Y-m-d H:i') : '',
                'time_formatted' => $timeFormatted,
                'date_group' => $dateGroup,
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

        Notification::where(function ($query) use ($user) {
            $query->where('user_id', $user->id);
            if ($user->parent_id && $user->parent_id > 0) {
                $query->orWhere('parent_id', $user->parent_id);
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

        $notification = Notification::find($id);
        if ($notification) {
            $notification->is_read = true;
            $notification->save();
        }

        return response()->json(['success' => true, 'message' => 'Notification marked as read']);
    }

    /**
     * Delete single notification
     */
    public function destroy(Request $request, $id)
    {
        $notification = Notification::find($id);
        if ($notification) {
            $notification->delete();
        }

        return response()->json(['success' => true, 'message' => 'Notification deleted successfully']);
    }

    /**
     * Clear all notifications for user
     */
    public function clearAll(Request $request)
    {
        $user = $request->user();

        Notification::where(function ($query) use ($user) {
            $query->where('user_id', $user->id);
            if ($user->parent_id && $user->parent_id > 0) {
                $query->orWhere('parent_id', $user->parent_id);
            }
        })->delete();

        return response()->json(['success' => true, 'message' => 'All notifications cleared']);
    }

    /**
     * Helper method to send in-app notification & optional FCM Push
     */
    public static function createNotification($userId, $type, $subject, $message, $parentId = 0)
    {
        $notification = Notification::create([
            'user_id' => $userId,
            'type' => $type,
            'subject' => $subject,
            'message' => $message,
            'module' => $type,
            'is_read' => false,
            'parent_id' => $parentId,
        ]);

        // Trigger FCM Push if target user has registered FCM token
        try {
            if ($userId && $userId > 0) {
                $targetUser = User::find($userId);
                if ($targetUser && !empty($targetUser->fcm_token)) {
                    FcmService::sendNotification(
                        $targetUser->fcm_token,
                        $subject,
                        $message,
                        [
                            'type' => $type,
                            'notification_id' => (string) $notification->id,
                        ]
                    );
                }
            }
        } catch (\Throwable $e) {
            \Log::warning('Failed to dispatch FCM push: ' . $e->getMessage());
        }

        return $notification;
    }
}
