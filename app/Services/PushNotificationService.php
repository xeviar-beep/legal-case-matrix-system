<?php

namespace App\Services;

use App\Models\PushSubscription;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Minishlink\WebPush\WebPush;
use Minishlink\WebPush\Subscription;

class PushNotificationService
{
    /**
     * Send notification to specific user (both in-system and push)
     */
    public function sendToUser($userId, $title, $body, $url = null, $icon = '/favicon.ico', $caseId = null)
    {
        // Create in-system notification
        $notification = Notification::create([
            'user_id' => $userId,
            'title' => $title,
            'body' => $body,
            'url' => $url,
            'case_id' => $caseId,
            'is_read' => false,
        ]);

        // Send push notification to all user's subscriptions
        $subscriptions = PushSubscription::where('user_id', $userId)->get();
        
        if ($subscriptions->isEmpty()) {
            Log::info("No push subscriptions found for user {$userId}");
            return $notification;
        }
        
        $sent = 0;
        foreach ($subscriptions as $subscription) {
            try {
                if ($this->sendPushNotification($subscription, $title, $body, $url, $icon)) {
                    $sent++;
                }
            } catch (\Exception $e) {
                Log::error("Failed to send push notification: " . $e->getMessage());
            }
        }
        
        Log::info("Notification sent to user {$userId}: {$sent} push notifications, 1 in-system notification");
        return $notification;
    }
    
    /**
     * Send push notification to all users with a specific role
     */
    public function sendToRole($role, $title, $body, $url = null, $icon = '/favicon.ico')
    {
        $users = User::where('role', $role)->where('is_active', true)->get();
        
        $sent = 0;
        foreach ($users as $user) {
            if ($this->sendToUser($user->id, $title, $body, $url, $icon)) {
                $sent++;
            }
        }
        
        return $sent;
    }
    
    /**
     * Send push notification to all subscribed users
     */
    public function sendToAll($title, $body, $url = null, $icon = '/favicon.ico')
    {
        $subscriptions = PushSubscription::all();
        
        $sent = 0;
        foreach ($subscriptions as $subscription) {
            try {
                $this->sendPushNotification($subscription, $title, $body, $url, $icon);
                $sent++;
            } catch (\Exception $e) {
                Log::error("Failed to send push notification: " . $e->getMessage());
            }
        }
        
        return $sent;
    }
    
    /**
     * Send notification about overdue case
     */
    public function notifyOverdueCase($case, $userId)
    {
        $title = "🚨 Case Overdue!";
        $body = "Case #{$case->case_number} is now overdue. Immediate action required.";
        $url = route('cases.show', $case->id);
        
        return $this->sendToUser($userId, $title, $body, $url, '/favicon.ico', $case->id);
    }
    
    /**
     * Send notification about upcoming deadline
     */
    public function notifyUpcomingDeadline($case, $userId, $hoursRemaining)
    {
        $days = ceil($hoursRemaining / 24);
        $title = "⏰ Deadline Approaching";
        $body = "Case #{$case->case_number} deadline is in {$days} days.";
        $url = route('cases.show', $case->id);
        
        return $this->sendToUser($userId, $title, $body, $url, '/favicon.ico', $case->id);
    }
    
    /**
     * Send notification about new case assignment
     */
    public function notifyNewAssignment($case, $userId)
    {
        $title = "📋 New Case Assignment";
        $body = "You have been assigned to Case #{$case->case_number}.";
        $url = route('cases.show', $case->id);
        
        return $this->sendToUser($userId, $title, $body, $url, '/favicon.ico', $case->id);
    }
    
    /**
     * Send notification about case status change
     */
    public function notifyCaseStatusChange($case, $userId, $oldStatus, $newStatus)
    {
        $title = "📝 Case Status Updated";
        $body = "Case #{$case->case_number} status changed from {$oldStatus} to {$newStatus}.";
        $url = route('cases.show', $case->id);
        
        return $this->sendToUser($userId, $title, $body, $url, '/favicon.ico', $case->id);
    }
    
    /**
     * Send notification about hearing today
     */
    public function notifyHearingToday($case, $userId)
    {
        $title = "📅 Hearing Today";
        $body = "Case #{$case->case_number} has a hearing scheduled today.";
        $url = route('cases.show', $case->id);
        
        return $this->sendToUser($userId, $title, $body, $url, '/favicon.ico', $case->id);
    }
    
    /**
     * Internal method to send push notification using Web Push Protocol
     */
    private function sendPushNotification($subscription, $title, $body, $url = null, $icon = '/favicon.ico')
    {
        try {
            // Check if VAPID keys are configured
            $publicKey = env('VAPID_PUBLIC_KEY');
            $privateKey = env('VAPID_PRIVATE_KEY');
            
            if (!$publicKey || !$privateKey) {
                Log::warning("VAPID keys not configured. Run: php artisan vendor:publish --tag=webpush-keys");
                return false;
            }
            
            // Create WebPush client with VAPID authentication
            $auth = [
                'VAPID' => [
                    'subject' => env('VAPID_SUBJECT', env('APP_URL', 'mailto:admin@example.com')),
                    'publicKey' => $publicKey,
                    'privateKey' => $privateKey,
                ]
            ];
            
            $webPush = new WebPush($auth);
            
            // Create subscription object
            $pushSubscription = Subscription::create([
                'endpoint' => $subscription->endpoint,
                'publicKey' => $subscription->public_key,
                'authToken' => $subscription->auth_token,
                'contentEncoding' => $subscription->content_encoding ?? 'aes128gcm',
            ]);
            
            // Prepare notification payload
            $payload = json_encode([
                'title' => $title,
                'body' => $body,
                'icon' => $icon,
                'badge' => '/favicon.ico',
                'url' => $url ?? '/dashboard',
                'tag' => 'notification-' . time(),
                'requireInteraction' => str_contains(strtolower($title), 'overdue') || str_contains(strtolower($title), 'urgent'),
                'vibrate' => [200, 100, 200],
                'actions' => [
                    ['action' => 'view', 'title' => 'View Case', 'icon' => '/favicon.ico'],
                    ['action' => 'dismiss', 'title' => 'Dismiss', 'icon' => '/favicon.ico'],
                ],
            ]);
            
            // Send notification
            $report = $webPush->sendOneNotification($pushSubscription, $payload);
            
            // Check if notification was sent successfully
            if ($report->isSuccess()) {
                Log::info("Push notification sent successfully", [
                    'user_id' => $subscription->user_id,
                    'title' => $title,
                ]);
                return true;
            } else {
                Log::error("Push notification failed", [
                    'user_id' => $subscription->user_id,
                    'reason' => $report->getReason(),
                ]);
                
                // If subscription is no longer valid, delete it
                if ($report->isSubscriptionExpired()) {
                    $subscription->delete();
                    Log::info("Removed expired subscription for user {$subscription->user_id}");
                }
                
                return false;
            }
            
        } catch (\Exception $e) {
            Log::error("Error sending push notification: " . $e->getMessage(), [
                'user_id' => $subscription->user_id,
                'exception' => $e,
            ]);
            return false;
        }
    }
}
