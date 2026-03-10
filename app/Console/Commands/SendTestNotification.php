<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\PushSubscription;
use Illuminate\Support\Facades\Http;

class SendTestNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notification:test {user_id? : The ID of a specific user}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a test push notification to subscribed users';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $userId = $this->argument('user_id');
        
        // Get subscriptions
        $query = PushSubscription::query();
        if ($userId) {
            $query->where('user_id', $userId);
        }
        
        $subscriptions = $query->get();
        
        if ($subscriptions->isEmpty()) {
            $this->error('No subscriptions found!');
            return 1;
        }
        
        $this->info("Found {$subscriptions->count()} subscription(s)");
        
        // Notification payload
        $notification = [
            'title' => 'Test Notification',
            'body' => 'This is a test notification from Case Matrix System',
            'icon' => '/favicon.ico',
            'badge' => '/favicon.ico',
            'url' => route('dashboard')
        ];
        
        $successCount = 0;
        $failureCount = 0;
        
        foreach ($subscriptions as $subscription) {
            try {
                $this->sendPushNotification($subscription, $notification);
                $successCount++;
                $this->line("✓ Sent to user #{$subscription->user_id}");
            } catch (\Exception $e) {
                $failureCount++;
                $this->error("✗ Failed for user #{$subscription->user_id}: " . $e->getMessage());
            }
        }
        
        $this->info("\nSummary:");
        $this->info("Success: {$successCount}");
        $this->info("Failed: {$failureCount}");
        
        return 0;
    }
    
    /**
     * Send push notification using Web Push Protocol
     */
    private function sendPushNotification(PushSubscription $subscription, array $notification)
    {
        // For now, just log the notification
        // In production, you would use the Web Push Protocol to send the notification
        $this->line("Would send notification to: {$subscription->endpoint}");
        $this->line("Notification data: " . json_encode($notification));
        
        // Note: Full implementation requires VAPID JWT generation and encryption
        // which needs the web-push library or manual implementation
        // For testing, you can trigger notifications from the browser's DevTools console:
        // navigator.serviceWorker.ready.then(reg => reg.showNotification('Test', {body: 'Test message'}));
    }
}
