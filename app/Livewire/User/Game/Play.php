<?php

namespace App\Livewire\User\Game;

use App\Models\Chess\Game;
use App\Models\Chess\Move;
use Livewire\Attributes\Layout;
use Livewire\Component;
use WireUi\Traits\WireUiActions;

class Play extends Component
{
    use WireUiActions;

    public $gameId;
    public $game;
    public $playerColor;
    public $canMove = false;
    public $moves = [];
    public $timeLeft = null;

    protected $listeners = ['moveMade' => 'refreshGame'];

    public function mount($gameId)
    {
        $this->gameId = $gameId;
        $this->loadGame();
    }

    public function loadGame()
    {
        $this->game = Game::with(['whitePlayer', 'blackPlayer', 'moves'])->findOrFail($this->gameId);
        
        // Check if user is authorized to access this game
        if (!$this->game->isPlayerInGame(auth()->user())) {
            abort(403, 'شما مجاز به دسترسی به این بازی نیستید');
        }

        $this->playerColor = $this->game->getPlayerColor(auth()->user());
        $this->canMove = $this->game->canPlayerMove(auth()->user());
        $this->moves = $this->game->moves->toArray();
        $this->timeLeft = $this->game->formatted_time_left;
    }

    public function refreshGame()
    {
        $this->loadGame();
    }

    public function makeMove($from, $to)
    {
        if (!$this->canMove) {
            return;
        }

        // Here you would implement the chess move validation using chess.js
        // For now, we'll create a simple move record
        $moveNumber = count($this->moves) + 1;
        
        Move::create([
            'game_id' => $this->game->id,
            'from_square' => $from,
            'to_square' => $to,
            'piece' => 'P', // This should be determined by the actual piece
            'san' => $from . '-' . $to,
            'move_number' => $moveNumber,
            'fen_after_move' => $this->game->fen, // This should be updated with new FEN
        ]);

        // Update game turn
        $this->game->update([
            'turn' => $this->game->turn === 'white' ? 'black' : 'white',
        ]);

        $this->refreshGame();
        $this->dispatch('moveMade');
    }

    public function startGame()
    {
        if (auth()->user()->isAdmin()) {
            $this->game->startGame();
            $this->refreshGame();
            $this->notification()->success(
                $title = 'بازی شروع شد',
                $description = 'بازی با موفقیت شروع شد'
            );
        }
    }

    public function endGame($result)
    {
        if (auth()->user()->isAdmin()) {
            $this->game->endGame($result);
            $this->refreshGame();
            $this->notification()->success(
                $title = 'بازی پایان یافت',
                $description = 'بازی با موفقیت پایان یافت'
            );
        }
    }

    #[Layout('components.layouts.app')]
    public function render()
    {
        return view('livewire.user.game.play');
    }
}
