<?php

namespace App\Console\Commands;

use App\Models\CaseModel;
use App\Models\User;
use App\Services\PushNotificationService;
use Illuminate\Console\Command;
use Carbon\Carbon;

class CheckCaseNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cases:check-notifications';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check for case notifications (overdue, upcoming deadlines, hearings today)';

    protected $pushService;

    /**
     * Create a new command instance.
     */
    public function __construct(PushNotificationService $pushService)
    {
        parent::__construct();
        $this->pushService = $pushService;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Checking for case notifications...');
        
        $overdueCount = $this->checkOverdueCases();
        $deadlineCount = $this->checkUpcomingDeadlines();
        $hearingCount = $this->checkHearingsToday();
        
        $this->info("Sent {$overdueCount} overdue notifications");
        $this->info("Sent {$deadlineCount} deadline notifications");
        $this->info("Sent {$hearingCount} hearing notifications");
        $this->info('Notification check completed!');
        
        return 0;
    }

    /**
     * Check for overdue cases and send notifications
     */
    protected function checkOverdueCases()
    {
        $overdueCases = CaseModel::where('deadline_date', '<', Carbon::now())
            ->where('status', '!=', 'closed')
            ->get();
        
        $count = 0;
        foreach ($overdueCases as $case) {
            // Get all users who should be notified (admins and assigned lawyer)
            $users = $this->getUsersToNotify($case);
            
            foreach ($users as $user) {
                // Check if notification was already sent today
                if (!$this->wasNotificationSentToday($user->id, $case->id, 'overdue')) {
                    $this->pushService->notifyOverdueCase($case, $user->id);
                    $count++;
                }
            }
        }
        
        return $count;
    }

    /**
     * Check for upcoming deadlines (within 3 days) and send notifications
     */
    protected function checkUpcomingDeadlines()
    {
        $threeDaysFromNow = Carbon::now()->addDays(3);
        
        $upcomingCases = CaseModel::whereBetween('deadline_date', [
                Carbon::now()->startOfDay(),
                $threeDaysFromNow->endOfDay()
            ])
            ->where('status', '!=', 'closed')
            ->get();
        
        $count = 0;
        foreach ($upcomingCases as $case) {
            $daysRemaining = Carbon::now()->diffInDays($case->deadline_date, false);
            
            // Only notify for 3 days, 2 days, and 1 day remaining
            if (in_array($daysRemaining, [1, 2, 3])) {
                $users = $this->getUsersToNotify($case);
                
                foreach ($users as $user) {
                    if (!$this->wasNotificationSentToday($user->id, $case->id, 'deadline')) {
                        $hoursRemaining = $daysRemaining * 24;
                        $this->pushService->notifyUpcomingDeadline($case, $user->id, $hoursRemaining);
                        $count++;
                    }
                }
            }
        }
        
        return $count;
    }

    /**
     * Check for hearings today and send notifications
     */
    protected function checkHearingsToday()
    {
        $today = Carbon::today();
        
        $hearingCases = CaseModel::whereDate('hearing_date', $today)
            ->where('status', '!=', 'closed')
            ->get();
        
        $count = 0;
        foreach ($hearingCases as $case) {
            $users = $this->getUsersToNotify($case);
            
            foreach ($users as $user) {
                if (!$this->wasNotificationSentToday($user->id, $case->id, 'hearing')) {
                    $this->pushService->notifyHearingToday($case, $user->id);
                    $count++;
                }
            }
        }
        
        return $count;
    }

    /**
     * Get users who should be notified about a case
     */
    protected function getUsersToNotify($case)
    {
        $users = collect();
        
        // Add admins
        $admins = User::where('role', 'admin')
            ->where('is_active', true)
            ->get();
        
        $users = $users->concat($admins);
        
        // Add assigned lawyer if exists
        if ($case->assigned_lawyer) {
            $lawyer = User::where('name', $case->assigned_lawyer)
                ->where('is_active', true)
                ->first();
            if ($lawyer) {
                $users->push($lawyer);
            }
        }
        
        return $users->unique('id');
    }

    /**
     * Check if notification was already sent today
     */
    protected function wasNotificationSentToday($userId, $caseId, $type)
    {
        $keywords = [
            'overdue' => 'Overdue',
            'deadline' => 'Deadline Approaching',
            'hearing' => 'Hearing Today',
        ];
        
        $keyword = $keywords[$type] ?? '';
        
        return \App\Models\Notification::where('user_id', $userId)
            ->where('case_id', $caseId)
            ->where('title', 'LIKE', "%{$keyword}%")
            ->whereDate('created_at', Carbon::today())
            ->exists();
    }
}
