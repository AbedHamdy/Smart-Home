<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\DatabaseMessage;

class InspectionReportSubmittedToAdmin extends Notification
{
    use Queueable;

    protected $order;

    public function __construct($order)
    {
        $this->order = $order;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => 'Inspection Report Submitted',
            'message' => "Technician has submitted an inspection report for request # {$this->order->title}",
            'order_id' => $this->order->id,
            'url' => route('admin_service_request.show', $this->order->id),
            'type' => 'inspection_report_admin',
        ];
    }
}
