<?php

namespace App\Notifications;

use App\Models\Event;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EventClosedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public Event $event
    ) {}

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toArray($notifiable): array
    {
        return [
            'event_id' => $this->event->id,
            'event_name' => $this->event->name,
            'message' => "Event '{$this->event->name}' has been automatically closed as it has passed its scheduled time.",
            'event_datetime' => $this->event->event_datetime->format('M d, Y g:i A'),
        ];
    }
}
