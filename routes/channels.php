<?php

use Illuminate\Support\Facades\Broadcast;
use App\Models\Chess\Game;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('game.{id}', function ($user, $id) {
    $game = Game::find($id);
    if (!$game) {
        return false;
    }
    return (int)$user->id === (int)$game->white_user_id || (int)$user->id === (int)$game->black_user_id;
});
