<?php

namespace App\Notifications;

use App\Models\BusinessInquiry;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewBusinessInquiryNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(private readonly BusinessInquiry $inquiry)
    {
    }

    /**
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject("New business inquiry from {$this->inquiry->name}")
            ->line("**Campaign type:** {$this->inquiry->campaign_type}")
            ->line("**Company:** ".($this->inquiry->company ?: '—'))
            ->line("**Budget:** ".($this->inquiry->budget ?: '—'))
            ->line("**Timeline:** ".($this->inquiry->timeline ?: '—'))
            ->line("**Email:** {$this->inquiry->email}")
            ->line('**Message:**')
            ->line($this->inquiry->message)
            ->action('View in Admin', url('/admin/business-inquiries/'.$this->inquiry->id.'/edit'));
    }
}
