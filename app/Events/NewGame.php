<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class NewGame implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $destinationUserId;
    public $gameId;
    public $from;

    public function __construct($destinationUserId, $gameId, $from)
    {
        $this->destinationUserId = $destinationUserId;
        $this->gameId = $gameId;
        $this->from = $from;
    }

    public function broadcastOn()
    {
        return new Channel('new-game-channel');
    }
}
