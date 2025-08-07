<?php

namespace App\Models\Chess;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Game extends Model
{
    use HasFactory;

    protected $fillable = [
        'white_player_id',
        'black_player_id',
        'fen',
        'turn',
        'status',
        'result',
        'start_at',
        'end_at',
    ];

    protected $casts = [
        'start_at' => 'datetime',
        'end_at' => 'datetime',
    ];

    public function whitePlayer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'white_player_id');
    }

    public function blackPlayer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'black_player_id');
    }

    public function moves(): HasMany
    {
        return $this->hasMany(Move::class)->orderBy('move_number');
    }

    public function getCurrentPlayerAttribute()
    {
        return $this->turn === 'white' ? $this->whitePlayer : $this->blackPlayer;
    }

    public function getOpponentAttribute()
    {
        return $this->turn === 'white' ? $this->blackPlayer : $this->whitePlayer;
    }

    public function isPlayerInGame(User $user): bool
    {
        return $this->white_player_id === $user->id || $this->black_player_id === $user->id;
    }

    public function getPlayerColor(User $user): ?string
    {
        if ($this->white_player_id === $user->id) {
            return 'white';
        }
        if ($this->black_player_id === $user->id) {
            return 'black';
        }
        return null;
    }

    public function canPlayerMove(User $user): bool
    {
        if (!$this->isPlayerInGame($user)) {
            return false;
        }

        $playerColor = $this->getPlayerColor($user);
        return $this->status === 'active' && $this->turn === $playerColor;
    }

    public function startGame(): void
    {
        $this->update([
            'status' => 'active',
            'start_at' => now(),
        ]);
    }

    public function endGame(string $result): void
    {
        $this->update([
            'status' => 'completed',
            'result' => $result,
            'end_at' => now(),
        ]);
    }

    public function getTimeLeftAttribute()
    {
        if (!$this->end_at) {
            return null;
        }

        $timeLeft = $this->end_at->diffInSeconds(now());
        return max(0, $timeLeft);
    }

    public function getFormattedTimeLeftAttribute()
    {
        $timeLeft = $this->time_left;
        if ($timeLeft === null) {
            return null;
        }

        $hours = floor($timeLeft / 3600);
        $minutes = floor(($timeLeft % 3600) / 60);
        $seconds = $timeLeft % 60;

        return sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
    }
}
