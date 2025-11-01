<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class InspectionReportSubmittedToClient extends Notification
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
            'message' => "The technician has submitted an inspection report for your request # {$this->order->title}. Repair cost: " . number_format($this->order->repair_cost, 2) . " EGP. Please review and approve.",
            'order_id' => $this->order->id,
            'url' => route('client.service_request.show', $this->order->id),
            'type' => 'inspection_report_client',
        ];
    }
}
