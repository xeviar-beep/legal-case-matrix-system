<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Notification;

class CheckNotifications extends Command
{
    protected $signature = 'check:notifications';
    protected $description = 'Check notifications in database';

    public function handle()
    {
        $notifications = Notification::with('case')->orderBy('created_at', 'desc')->get();
        
        $this->info("Total notifications: " . $notifications->count());
        
        foreach ($notifications as $notification) {
            $this->info("\nID: {$notification->id}");
            $this->info("Title: {$notification->title}");
            $this->info("Body: {$notification->body}");
            $this->info("Case: " . ($notification->case ? $notification->case->case_number : 'N/A'));
            $this->info("Read: " . ($notification->is_read ? 'Yes' : 'No'));
            $this->info("Created: {$notification->created_at}");
        }
        
        return 0;
    }
}
