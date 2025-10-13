<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TechnicianVerificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $technicianName;
    public $verificationCode;

    public function __construct($technicianName, $verificationCode)
    {
        $this->technicianName = $technicianName;
        $this->verificationCode = $verificationCode;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Verify Your Technician Account',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.technician_verification',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
