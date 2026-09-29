<?php

namespace App\Events;

use App\Models\Event;
use App\Models\Signer;
use App\Models\SigningSession;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SignerRequested implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public Event $event,
        public Signer $signer,
        public SigningSession $session,
    ) {
    }

    public function broadcastOn(): array
    {
        return [
            new Channel('signing.device'),
            new Channel('signing.event.' . $this->event->id),
        ];
    }

    public function broadcastAs(): string
    {
        return 'SignerRequested';
    }

    public function broadcastWith(): array
    {
        return [
            'event_id' => $this->event->id,
            'session_id' => $this->session->id,

            'signer' => [
                'id' => $this->signer->id,
                'name' => $this->signer->name,
                'position' => $this->signer->position,
                'organization' => $this->signer->organization,
            ],
        ];
    }
}
