<?php

namespace App\Livewire\Admin\Game;

use App\Models\Chess\Game;
use App\Models\User;
use LivewireUI\Modal\ModalComponent;

class Create extends ModalComponent
{
    public ?int $white_user_id = null;
    public ?int $black_user_id = null;
    public string $turn = Game::TURN_WHITE;
    public string $fen = '';

    public function mount()
    {
        // Standard starting position FEN
        $this->fen = 'rnbqkbnr/pppppppp/8/8/8/8/PPPPPPPP/RNBQKBNR w KQkq - 0 1';
        $this->turn = Game::TURN_WHITE;
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

    public function save()
    {
        $data = $this->validate();
        Game::create($data);
        $this->dispatch('gameSaved');
        session()->flash('message', __('Game created successfully'));
        $this->dispatch('closeModal');
        $this->reset(['white_user_id', 'black_user_id']);
        $this->turn = Game::TURN_WHITE;
        $this->fen = 'rnbqkbnr/pppppppp/8/8/8/8/PPPPPPPP/RNBQKBNR w KQkq - 0 1';
    }

    public function getUsersProperty()
    {
        return User::query()->orderBy('name')->get(['id','name','email']);
    }

    public function render()
    {
        return view('livewire.admin.game.create', [
            'users' => $this->users,
        ]);
    }
}
