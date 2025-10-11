<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TechnicianApplicationSubmitted extends Notification
{
    use Queueable;

    protected $technician;

    /**
     * Create a new notification instance.
     */
    public function __construct($technician)
    {
        $this->technician = $technician;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'New Technician Application',
            'message' => "A new technician named {$this->technician->name} submitted an application.",
            'technician_id' => $this->technician->id,
            'url' => route('admin_technician_requests.show', $this->technician->id)
        ];
    }
}
