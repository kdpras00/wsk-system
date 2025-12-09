<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ReportStatusChanged extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    protected $report;
    protected $status;

    /**
     * Create a new notification instance.
     */
    public function __construct($report, $status)
    {
        $this->report = $report;
        $this->status = $status;
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
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        $color = $this->status === 'Approved' ? 'success' : 'danger';
        $message = "Laporan tanggal " . $this->report->production_date->format('d M') . " telah " . $this->status;
        
        return [
            'title' => 'Status Laporan Diupdate',
            'message' => $message,
            'url' => route('daily-reports.index'), // Safe URL for Operator
            'type' => $color
        ];
    }
}
