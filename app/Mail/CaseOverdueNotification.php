<?php

namespace App\Mail;

use App\Models\CaseModel;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CaseOverdueNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $case;
    public $daysOverdue;

    public function __construct(CaseModel $case, $daysOverdue)
    {
        $this->case = $case;
        $this->daysOverdue = $daysOverdue;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "🚨 URGENT: Case #{$this->case->case_number} is {$this->daysOverdue} Day(s) Overdue",
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.case-overdue',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
