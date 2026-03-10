<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\PushSubscription;
use App\Services\PushNotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class NotificationController extends Controller
{
    protected $pushService;

    public function __construct(PushNotificationService $pushService)
    {
        $this->middleware('auth');
        $this->pushService = $pushService;
    }

    /**
     * Display notifications page
     */
    public function index()
    {
        $notificationsQuery = Auth::user()
            ->notifications()
            ->with('case')
            ->orderBy('created_at', 'desc');

        // Get all notifications for stats and filtering
        $allNotificationsRaw = $notificationsQuery->get();

        // Transform notifications to match view format
        $allNotifications = $allNotificationsRaw->filter(function($notification) {
            // Only include notifications with an associated case for the case-based view
            return $notification->case !== null;
        })->map(function($notification) {
            // Determine type based on title
            $type = 'info';
            if (str_contains(strtolower($notification->title), 'overdue') || str_contains($notification->title, '🚨')) {
                $type = 'critical';
            } elseif (str_contains(strtolower($notification->title), 'deadline') || str_contains($notification->title, '⏰')) {
                $type = 'warning';
            }

            return [
                'id' => $notification->id,
                'type' => $type,
                'title' => $notification->title,
                'message' => $notification->body,
                'case' => $notification->case,
                'created_at' => $notification->created_at,
                'read' => $notification->is_read,
                'url' => $notification->url,
            ];
        });

        // Paginate the raw notifications for pagination links
        $notifications = $notificationsQuery->paginate(20);

        // Calculate stats
        $critical = $allNotifications->where('type', 'critical')->count();
        $warning = $allNotifications->where('type', 'warning')->count();
        $info = $allNotifications->where('type', 'info')->count();

        $stats = [
            'total' => $allNotifications->count(),
            'critical' => $critical,
            'warning' => $warning,
            'info' => $info,
        ];

        return view('notifications.index', compact('notifications', 'allNotifications', 'stats'));
    }

    /**
     * Get notifications for dropdown (API)
     */
    public function getNotifications()
    {
        $notifications = Auth::user()
            ->notifications()
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        $unreadCount = Auth::user()
            ->notifications()
            ->unread()
            ->count();

        return response()->json([
            'success' => true,
            'notifications' => $notifications->map(function($notification) {
                return [
                    'id' => $notification->id,
                    'title' => $notification->title,
                    'body' => $notification->body,
                    'url' => $notification->url,
                    'is_read' => $notification->is_read,
                    'time_ago' => $notification->time_ago,
                    'created_at' => $notification->created_at->format('Y-m-d H:i:s'),
                ];
            }),
            'unread_count' => $unreadCount,
        ]);
    }

    /**
     * Mark notification as read
     */
    public function markAsRead($id)
    {
        $notification = Auth::user()
            ->notifications()
            ->findOrFail($id);

        $notification->markAsRead();

        return response()->json([
            'success' => true,
            'message' => 'Notification marked as read',
        ]);
    }

    /**
     * Mark all notifications as read
     */
    public function markAllAsRead()
    {
        Auth::user()
            ->notifications()
            ->unread()
            ->update([
                'is_read' => true,
                'read_at' => now(),
            ]);

        return response()->json([
            'success' => true,
            'message' => 'All notifications marked as read',
        ]);
    }

    /**
     * Delete notification
     */
    public function destroy($id)
    {
        $notification = Auth::user()
            ->notifications()
            ->findOrFail($id);

        $notification->delete();

        return response()->json([
            'success' => true,
            'message' => 'Notification deleted',
        ]);
    }

    /**
     * Send test notification
     */
    public function sendTest()
    {
        try {
            $user = Auth::user();
            
            // Use the push service to send both in-system and browser notifications
            $this->pushService->sendToUser(
                $user->id,
                '🔔 Test Notification',
                'This is a test notification from LAO Case Matrix System. Everything is working correctly!',
                route('notifications.index')
            );

            return response()->json([
                'success' => true,
                'message' => 'Test notification sent successfully',
            ]);
        } catch (\Exception $e) {
            Log::error('Test notification failed: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to send test notification: ' . $e->getMessage(),
            ], 500);
        }
    }
}
