<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class IssueReported extends Notification
{
    use Queueable;

    protected $order;
    protected $forAdmin;

    public function __construct($order, $forAdmin = false)
    {
        $this->order = $order;
        $this->forAdmin = $forAdmin;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        if ($this->forAdmin)
        {
            return [
                'title' => 'Issue Reported',
                'message' => "Technician reported issue for request #{$this->order->title}: {$this->order->issue_type}",
                'order_id' => $this->order->id,
                'type' => 'issue_report_admin',
                'url' => route('admin_technician_requests.show', $this->order->id),
            ];
        }

        return [
            'title' => 'Issue Reported',
            'message' => "The technician has reported an issue with your request #{$this->order->title}. Our team is reviewing it.",
            'order_id' => $this->order->id,
            'type' => 'issue_report_client',
            'url' => route('client.service_request.show', $this->order->id),
        ];
    }
}
