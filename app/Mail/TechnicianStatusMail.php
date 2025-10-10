<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TechnicianStatusMail extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $status;
    public $password;

    /**
     * Create a new message instance.
     */
    public function __construct($name, $status, $password = null)
    {
        $this->name = $name;
        $this->status = $status;
        $this->password = $password;
    }

    public function build()
    {
        if ($this->status === 'approved')
        {
            return $this->subject('Your Technician Account Has Been Approved')
                ->view('emails.technician_approved')
                ->with([
                    'name' => $this->name,
                    'password' => $this->password,
                ]);
        }
        else
        {
            return $this->subject('Technician Application Update')
                ->view('emails.technician_rejected')
                ->with([
                    'name' => $this->name,
                ]);
        }
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
