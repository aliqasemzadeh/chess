<?php

namespace App\Models\Chess;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Move extends Model
{
    use HasFactory;

    protected $fillable = [
        'game_id',
        'from_square',
        'to_square',
        'piece',
        'san',
        'move_number',
        'fen_after_move',
    ];

    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class);
    }

    public function getFormattedMoveAttribute()
    {
        return $this->san ?? "{$this->from_square}-{$this->to_square}";
    }
}
