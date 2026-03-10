<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // Send daily reminders at 8:00 AM (email summary)
        $schedule->command('reminders:send')
                 ->dailyAt('08:00')
                 ->timezone('Asia/Manila')
                 ->withoutOverlapping();
        
        // Check deadlines and send push notifications every hour during work hours
        $schedule->command('deadlines:check')
                 ->hourly()
                 ->between('7:00', '19:00')
                 ->timezone('Asia/Manila')
                 ->withoutOverlapping();
        
        // Also check at the start of work day for immediate alerts
        $schedule->command('deadlines:check')
                 ->dailyAt('08:00')
                 ->timezone('Asia/Manila');
        
        // Check at lunch time
        $schedule->command('deadlines:check')
                 ->dailyAt('12:00')
                 ->timezone('Asia/Manila');
        
        // Final check before end of day
        $schedule->command('deadlines:check')
                 ->dailyAt('17:00')
                 ->timezone('Asia/Manila');
        
        // Check case notifications (overdue, upcoming deadlines, hearings) every hour
        $schedule->command('cases:check-notifications')
                 ->hourly()
                 ->timezone('Asia/Manila')
                 ->withoutOverlapping();
        
        // Morning notification check
        $schedule->command('cases:check-notifications')
                 ->dailyAt('08:00')
                 ->timezone('Asia/Manila');
        
        // Afternoon notification check
        $schedule->command('cases:check-notifications')
                 ->dailyAt('14:00')
                 ->timezone('Asia/Manila');
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
