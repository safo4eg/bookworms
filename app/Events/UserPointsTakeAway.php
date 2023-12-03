<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserPointsTakeAway
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $trigger;
    public function __construct(object $trigger)
    {
        $this->trigger = $trigger;
    }
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}
