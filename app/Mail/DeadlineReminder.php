<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DeadlineReminder extends Mailable
{
    use Queueable, SerializesModels;

    public $reminderData;

    /**
     * Create a new message instance.
     */
    public function __construct($reminderData)
    {
        $this->reminderData = $reminderData;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $totalUrgent = count($this->reminderData['overdueCases']) + 
                      count($this->reminderData['deadlinesToday']);
        
        $subject = $totalUrgent > 0 
            ? "⚠️ URGENT: {$totalUrgent} Case Deadline(s) Require Immediate Attention"
            : "📌 Daily Case Reminder - " . $this->reminderData['date'];

        return new Envelope(
            subject: $subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.deadline-reminder',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
