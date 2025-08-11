<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Chess\Game;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Relationships
     */
    public function gamesAsWhite()
    {
        return $this->hasMany(Game::class, 'white_user_id');
    }

    public function gamesAsBlack()
    {
        return $this->hasMany(Game::class, 'black_user_id');
    }

    /**
     * All games where the user participates (as white or black).
     * Note: uses hasMany base with orWhere to include black side as well.
     */
    public function games()
    {
        return $this->hasMany(Game::class, 'white_user_id')
            ->orWhere('black_user_id', $this->id);
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
