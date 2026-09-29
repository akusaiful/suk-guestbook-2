<?php

namespace App\Events;

use App\Models\Event;
use App\Models\SigningSession;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SigningCancelled implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public Event $event,
        public SigningSession $session
    ) {
    }

    public function broadcastOn(): array
    {
        return [
            new Channel('signing.device'),
        ];
    }

    public function broadcastAs(): string
    {
        return 'SigningCancelled';
    }

    public function broadcastWith(): array
    {
        return [
            'event_id' => $this->event->id,
            'session_id' => $this->session->id,
        ];
    }
}