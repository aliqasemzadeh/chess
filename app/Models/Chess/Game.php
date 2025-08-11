<?php

namespace App\Models\Chess;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    public const TURN_WHITE = 'white';
    public const TURN_BLACK = 'black';

    protected $fillable = [
        'white_user_id',
        'black_user_id',
        'turn',
        'fen',
    ];

    // Relationships
    public function white()
    {
        return $this->belongsTo(User::class, 'white_user_id');
    }

    public function black()
    {
        return $this->belongsTo(User::class, 'black_user_id');
    }

    public function moves()
    {
        return $this->hasMany(Move::class)->orderBy('move_number');
    }

    // Accessor for a human-readable turn label
    public function getTurnLabelAttribute(): string
    {
        return $this->turn === self::TURN_WHITE ? __('White') : __('Black');
    }
}
