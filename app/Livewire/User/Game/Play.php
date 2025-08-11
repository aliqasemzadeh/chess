<?php

namespace App\Livewire\User\Game;

use App\Events\GameMoveEvent;
use App\Jobs\GameMoveJob;
use App\Models\Chess\Game;
use App\Models\Chess\Move;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;

class Play extends Component
{
    public Game $game;
    public string $fen;

    public function mount(int $id)
    {
        $this->game = Game::with(['white', 'black', 'moves'])
            ->findOrFail($id);
        $this->fen = $this->game->fen;
    }

    #[Layout('layouts.user')]
    public function render()
    {
        // Ensure moves and players are loaded and ordered
        $this->game->loadMissing(['white', 'black', 'moves']);

        return view('livewire.user.game.play', [
            'game' => $this->game,
            'fen' => $this->fen,
        ]);
    }

    /**
     * Persist a move after client-side validation by chess.js.
     * $payload should contain: from, to, san, fen_before, fen_after, meta(optional)
     */
    public function saveMove(array $payload): void
    {
        $user = Auth::user();
        if (!$user) {
            abort(403);
        }

        // Basic guard: ensure user belongs to the game
        if ($user->id !== (int)$this->game->white_user_id && $user->id !== (int)$this->game->black_user_id) {
            throw ValidationException::withMessages(['move' => __('You are not a participant in this game.')]);
        }

        // Ensure it's player's turn (based on current game->turn and FEN active color)
        $activeTurn = $this->game->turn; // 'white' or 'black'
        $isWhite = $user->id === (int)$this->game->white_user_id;
        if (($activeTurn === Game::TURN_WHITE && !$isWhite) || ($activeTurn === Game::TURN_BLACK && $isWhite)) {
            throw ValidationException::withMessages(['move' => __('It is not your turn.')]);
        }

        // Move number = previous moves + 1
        $moveNumber = Move::where('game_id', $this->game->id)->count() + 1;

        // Create Move
        $move = Move::create([
            'game_id' => $this->game->id,
            'user_id' => $user->id,
            'move_number' => $moveNumber,
            'from' => $payload['from'] ?? '',
            'to' => $payload['to'] ?? '',
            'san' => $payload['san'] ?? '',
            'fen_before' => $payload['fen_before'] ?? $this->game->fen,
            'fen_after' => $payload['fen_after'] ?? '',
            'meta' => $payload['meta'] ?? null,
        ]);

        // Update game FEN and turn
        $this->game->fen = $move->fen_after;
        $this->game->turn = $this->game->turn === Game::TURN_WHITE ? Game::TURN_BLACK : Game::TURN_WHITE;
        $this->game->save();
        $this->fen = $this->game->fen;

        // Refresh game with moves to update history in UI
        $this->game->load(['moves', 'white', 'black']);

        // Broadcast the move to other subscribers
        broadcast(new GameMoveEvent(
            $this->game->id,
            [
                'from' => $move->from,
                'to' => $move->to,
                'san' => $move->san,
                'move_number' => $move->move_number,
                'user_id' => $move->user_id,
            ],
            $this->game->fen
        ))->toOthers();

        // Dispatch browser event (optional in-UI hook)
        $this->dispatch('move-saved', fen: $this->fen);
    }

    /**
     * Handle move from client-side JavaScript
     */
    #[On('client-move')]
    public function handleMove(array $payload): void
    {
        $this->saveMove($payload);
    }
}
