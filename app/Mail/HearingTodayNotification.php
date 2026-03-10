<?php

namespace App\Mail;

use App\Models\CaseModel;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class HearingTodayNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $case;

    public function __construct(CaseModel $case)
    {
        $this->case = $case;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "👨‍⚖️ Court Hearing Today: Case #{$this->case->case_number}",
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.hearing-today',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
