<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class GameMoveEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public int $gameId;
    public array $move;
    public string $fen;

    public function __construct(int $gameId, array $move, string $fen)
    {
        $this->gameId = $gameId;
        $this->move = $move;
        $this->fen = $fen;
    }

    public function broadcastOn(): Channel
    {
        return new PrivateChannel('game.' . $this->gameId);
    }

    public function broadcastAs(): string
    {
        return 'game.move';
    }
}
