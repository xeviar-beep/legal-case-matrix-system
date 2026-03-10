<?php

namespace App\Mail;

use App\Models\CaseModel;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DeadlineUpcomingNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $case;
    public $urgency; // 'today', 'tomorrow', '3days'

    public function __construct(CaseModel $case, $urgency)
    {
        $this->case = $case;
        $this->urgency = $urgency;
    }

    public function envelope(): Envelope
    {
        $subject = match($this->urgency) {
            'today' => "⏰ DEADLINE TODAY: Case #{$this->case->case_number}",
            'tomorrow' => "📅 Deadline Tomorrow: Case #{$this->case->case_number}",
            '3days' => "📌 Upcoming Deadline: Case #{$this->case->case_number} (3 Days)",
            default => "Deadline Reminder: Case #{$this->case->case_number}",
        };

        return new Envelope(subject: $subject);
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.deadline-upcoming',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
