<?php

namespace App\Console\Commands;

use App\Models\CaseModel;
use App\Mail\DeadlineReminder;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class SendDeadlineReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminders:send {--test : Run in test mode without sending emails}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send daily deadline reminders for cases';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔔 Checking for deadline reminders...');
        
        $today = Carbon::today();
        $reminderEmail = env('REMINDER_EMAIL_TO', config('mail.from.address'));
        
        // Get cases with deadlines today
        $deadlinesToday = CaseModel::whereDate('deadline_date', $today)
            ->where('status', '!=', 'completed')
            ->get();
        
        // Get cases with deadlines in 3 days
        $deadlinesIn3Days = CaseModel::whereDate('deadline_date', $today->copy()->addDays(3))
            ->where('status', '!=', 'completed')
            ->get();
        
        // Get cases with deadlines in 7 days
        $deadlinesIn7Days = CaseModel::whereDate('deadline_date', $today->copy()->addDays(7))
            ->where('status', '!=', 'completed')
            ->get();
        
        // Get overdue cases
        $overdueCases = CaseModel::where('deadline_date', '<', $today)
            ->where('status', '!=', 'completed')
            ->get();

        // Get hearings today
        $hearingsToday = CaseModel::whereDate('hearing_date', $today)->get();

        // Count total reminders
        $totalReminders = $deadlinesToday->count() + 
                         $deadlinesIn3Days->count() + 
                         $deadlinesIn7Days->count() + 
                         $overdueCases->count() +
                         $hearingsToday->count();

        if ($totalReminders === 0) {
            $this->info('✓ No reminders to send today.');
            return 0;
        }

        // Prepare reminder data
        $reminderData = [
            'date' => $today->format('F d, Y'),
            'deadlinesToday' => $deadlinesToday,
            'deadlinesIn3Days' => $deadlinesIn3Days,
            'deadlinesIn7Days' => $deadlinesIn7Days,
            'overdueCases' => $overdueCases,
            'hearingsToday' => $hearingsToday,
        ];

        // Display summary
        $this->newLine();
        $this->info('📊 Reminder Summary:');
        $this->line("  🔴 Overdue cases: {$overdueCases->count()}");
        $this->line("  ⏰ Deadlines today: {$deadlinesToday->count()}");
        $this->line("  ⚠️  Deadlines in 3 days: {$deadlinesIn3Days->count()}");
        $this->line("  📌 Deadlines in 7 days: {$deadlinesIn7Days->count()}");
        $this->line("  📅 Hearings today: {$hearingsToday->count()}");
        $this->newLine();

        // Send email
        if ($this->option('test')) {
            $this->warn('⚠️  TEST MODE: Email not sent');
            $this->info("Would send to: {$reminderEmail}");
        } else {
            try {
                Mail::to($reminderEmail)->send(new DeadlineReminder($reminderData));
                $this->info("✓ Reminder email sent to: {$reminderEmail}");
            } catch (\Exception $e) {
                $this->error("✗ Failed to send email: " . $e->getMessage());
                return 1;
            }
        }

        $this->info('✓ Reminder check completed!');
        return 0;
    }
}
