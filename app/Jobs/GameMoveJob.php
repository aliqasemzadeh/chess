<?php

namespace App\Jobs;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class GameMoveJob implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

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
