<?php

namespace App\Events;

use App\Models\Event;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SigningSessionUpdated implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public Event $event
    ) {
    }

    public function broadcastOn(): array
    {
        return [
            new Channel(
                'signing.event.' . $this->event->id
            ),
        ];
    }

    public function broadcastAs(): string
    {
        return 'SigningSessionUpdated';
    }

    public function broadcastWith(): array
    {
        return [
            'event_id' => $this->event->id,
        ];
    }
}