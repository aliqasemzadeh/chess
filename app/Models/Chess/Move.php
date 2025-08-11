<?php

namespace App\Models\Chess;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Move extends Model
{
    protected $fillable = [
        'game_id',
        'user_id',
        'move_number',
        'from',
        'to',
        'san',
        'fen_before',
        'fen_after',
        'meta',
    ];

    protected $casts = [
        'meta' => 'array',
    ];

    public function game()
    {
        return $this->belongsTo(Game::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
