<?php

namespace App\Console\Commands;

use App\Models\CaseModel;
use App\Models\User;
use App\Services\PushNotificationService;
use App\Mail\CaseOverdueNotification;
use App\Mail\DeadlineUpcomingNotification;
use App\Mail\HearingTodayNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class CheckDeadlinesAndNotify extends Command
{
    protected $signature = 'deadlines:check {--test : Run in test mode}';
    protected $description = 'Check case deadlines and send automatic push notifications';

    protected $pushService;

    public function __construct(PushNotificationService $pushService)
    {
        parent::__construct();
        $this->pushService = $pushService;
    }

    public function handle()
    {
        $this->info('🔔 Checking case deadlines for notifications...');
        
        $now = Carbon::now();
        $today = Carbon::today();
        
        // 1. Check for OVERDUE cases (past deadline)
        $this->checkOverdueCases($today);
        
        // 2. Check for deadlines TODAY
        $this->checkDeadlinesToday($today);
        
        // 3. Check for deadlines TOMORROW (24 hours)
        $this->checkDeadlinesTomorrow($today);
        
        // 4. Check for deadlines in 3 DAYS (early warning)
        $this->checkDeadlinesIn3Days($today);
        
        // 5. Check for HEARINGS today
        $this->checkHearingsToday($today);
        
        $this->info('✓ Deadline check completed!');
        return 0;
    }

    private function checkOverdueCases($today)
    {
        $overdueCases = CaseModel::where('deadline_date', '<', $today)
            ->whereNotIn('status', ['completed', 'closed', 'dismissed'])
            ->get();

        if ($overdueCases->isEmpty()) {
            $this->line('  ✓ No overdue cases');
            return;
        }

        $this->warn("  🚨 Found {$overdueCases->count()} overdue case(s)");

        foreach ($overdueCases as $case) {
            $daysOverdue = $today->diffInDays($case->deadline_date);
            
            $title = "🚨 URGENT: Case Overdue!";
            $body = "Case #{$case->case_number} - {$case->case_title} is {$daysOverdue} day(s) overdue. Immediate action required!";
            $url = "/cases/{$case->id}";

            if ($this->option('test')) {
                $this->line("    [TEST] Would notify: {$case->case_number} ({$daysOverdue} days overdue)");
            } else {
                // Create email notification
                $mail = new CaseOverdueNotification($case, $daysOverdue);
                
                // Notify assigned lawyer
                if ($case->user_id) {
                    $this->sendNotificationToUser($case->user_id, $title, $body, $url, $case, $mail);
                }
                
                // Also notify all admins
                $this->notifyAdmins($title, $body, $url, $mail);
                
                Log::info("Overdue notification sent for case: {$case->case_number}");
            }
        }
    }

    private function checkDeadlinesToday($today)
    {
        $casesToday = CaseModel::whereDate('deadline_date', $today)
            ->whereNotIn('status', ['completed', 'closed', 'dismissed'])
            ->get();

        if ($casesToday->isEmpty()) {
            $this->line('  ✓ No deadlines today');
            return;
        }

        $this->info("  ⏰ Found {$casesToday->count()} deadline(s) today");

        foreach ($casesToday as $case) {
            $title = "⏰ Deadline Today!";
            $body = "Case #{$case->case_number} - {$case->case_title} deadline is TODAY. Please take action.";
            $url = "/cases/{$case->id}";

            if ($this->option('test')) {
                $this->line("    [TEST] Would notify: {$case->case_number}");
            } else {
                $mail = new DeadlineUpcomingNotification($case, 'today');
                
                if ($case->user_id) {
                    $this->sendNotificationToUser($case->user_id, $title, $body, $url, $case, $mail);
                }
                Log::info("Today's deadline notification sent for case: {$case->case_number}");
            }
        }
    }

    private function checkDeadlinesTomorrow($today)
    {
        $tomorrow = $today->copy()->addDay();
        $casesTomorrow = CaseModel::whereDate('deadline_date', $tomorrow)
            ->whereNotIn('status', ['completed', 'closed', 'dismissed'])
            ->get();

        if ($casesTomorrow->isEmpty()) {
            $this->line('  ✓ No deadlines tomorrow');
            return;
        }

        $this->info("  📅 Found {$casesTomorrow->count()} deadline(s) tomorrow");

        foreach ($casesTomorrow as $case) {
            $title = "📅 Deadline Tomorrow";
            $body = "Case #{$case->case_number} - {$case->case_title} deadline is tomorrow. Please prepare.";
            $url = "/cases/{$case->id}";

            if ($this->option('test')) {
                $this->line("    [TEST] Would notify: {$case->case_number}");
            } else {
                $mail = new DeadlineUpcomingNotification($case, 'tomorrow');
                
                if ($case->user_id) {
                    $this->sendNotificationToUser($case->user_id, $title, $body, $url, $case, $mail);
                }
                Log::info("Tomorrow's deadline notification sent for case: {$case->case_number}");
            }
        }
    }

    private function checkDeadlinesIn3Days($today)
    {
        $in3Days = $today->copy()->addDays(3);
        $casesIn3Days = CaseModel::whereDate('deadline_date', $in3Days)
            ->whereNotIn('status', ['completed', 'closed', 'dismissed'])
            ->get();

        if ($casesIn3Days->isEmpty()) {
            $this->line('  ✓ No deadlines in 3 days');
            return;
        }

        $this->info("  📌 Found {$casesIn3Days->count()} deadline(s) in 3 days");

        foreach ($casesIn3Days as $case) {
            $title = "📌 Upcoming Deadline";
            $body = "Case #{$case->case_number} - {$case->case_title} deadline is in 3 days.";
            $url = "/cases/{$case->id}";

            if ($this->option('test')) {
                $this->line("    [TEST] Would notify: {$case->case_number}");
            } else {
                $mail = new DeadlineUpcomingNotification($case, '3days');
                
                if ($case->user_id) {
                    $this->sendNotificationToUser($case->user_id, $title, $body, $url, $case, $mail);
                }
                Log::info("3-day advance notification sent for case: {$case->case_number}");
            }
        }
    }

    private function checkHearingsToday($today)
    {
        $hearingsToday = CaseModel::whereDate('hearing_date', $today)
            ->whereNotIn('status', ['completed', 'closed', 'dismissed'])
            ->get();

        if ($hearingsToday->isEmpty()) {
            $this->line('  ✓ No hearings today');
            return;
        }

        $this->info("  👨‍⚖️ Found {$hearingsToday->count()} hearing(s) today");

        foreach ($hearingsToday as $case) {
            $title = "👨‍⚖️ Hearing Today!";
            $body = "Case #{$case->case_number} - {$case->case_title} has a hearing scheduled today.";
            $url = "/cases/{$case->id}";

            if ($this->option('test')) {
                $this->line("    [TEST] Would notify: {$case->case_number}");
            } else {
                $mail = new HearingTodayNotification($case);
                
                if ($case->user_id) {
                    $this->sendNotificationToUser($case->user_id, $title, $body, $url, $case, $mail);
                }
                Log::info("Hearing notification sent for case: {$case->case_number}");
            }
        }
    }

    private function sendNotificationToUser($userId, $title, $body, $url, $case, $mailClass = null)
    {
        try {
            $user = User::find($userId);
            
            if (!$user) {
                Log::warning("User not found: {$userId}");
                return;
            }

            // Store notification in database for later display
            \DB::table('notifications')->insert([
                'user_id' => $userId,
                'title' => $title,
                'body' => $body,
                'url' => $url,
                'case_id' => $case->id ?? null,
                'is_read' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Send push notification
            $this->pushService->sendToUser($userId, $title, $body, $url);
            
            // Send email notification if mailClass is provided and email is properly configured
            if ($mailClass && $user->email && env('MAIL_USERNAME') && env('MAIL_USERNAME') !== 'your-email@gmail.com') {
                try {
                    Mail::to($user->email)->send($mailClass);
                    Log::info("Email sent to {$user->email} for case notification");
                } catch (\Exception $e) {
                    Log::warning("Could not send email to {$user->email}: " . $e->getMessage());
                }
            }
            
        } catch (\Exception $e) {
            Log::error("Failed to send notification: " . $e->getMessage());
        }
    }

    private function notifyAdmins($title, $body, $url, $mail = null)
    {
        $admins = User::where('role', 'admin')->where('is_active', true)->get();
        
        foreach ($admins as $admin) {
            $this->sendNotificationToUser($admin->id, $title, $body, $url, (object)['id' => null], $mail);
        }
    }
}
