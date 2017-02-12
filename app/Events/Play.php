<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class Play implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $gameId;
    public $type;
    public $location;
    public $userId;

    public function __construct($gameId, $userId, $location, $type)
    {
        $this->gameId = $gameId;
        $this->location = $location;
        $this->type = $type;
        $this->userId = $userId;
    }

    public function broadcastOn()
    {
        return new Channel('game-channel-' . $this->gameId . '-' . $this->userId);
    }
}
