<?php

namespace App\Livewire\Admin\Game;

use App\Models\Chess\Game;
use App\Models\User;
use LivewireUI\Modal\ModalComponent;

class Edit extends ModalComponent
{
    public ?Game $game = null;
    public ?int $white_user_id = null;
    public ?int $black_user_id = null;
    public string $turn = Game::TURN_WHITE;
    public string $fen = '';

    public function mount(?int $gameId = null)
    {
        if ($gameId) {
            $this->game = Game::findOrFail($gameId);
            $this->white_user_id = $this->game->white_user_id;
            $this->black_user_id = $this->game->black_user_id;
            $this->turn = $this->game->turn;
            $this->fen = $this->game->fen;
        }
    }

    protected function rules(): array
    {
        return [
            'white_user_id' => ['required', 'different:black_user_id', 'exists:users,id'],
            'black_user_id' => ['required', 'different:white_user_id', 'exists:users,id'],
            'turn' => ['required', 'in:white,black'],
            'fen' => ['required', 'string'],
        ];
    }

    public function update()
    {
        $data = $this->validate();
        $this->game->update($data);
        $this->dispatch('gameSaved');
        session()->flash('message', __('Game updated successfully'));
        $this->dispatch('closeModal');
    }

    public function getUsersProperty()
    {
        return User::query()->orderBy('name')->get(['id','name','email']);
    }

    public function render()
    {
        return view('livewire.admin.game.edit', [
            'users' => $this->users,
        ]);
    }
}
