<?php

namespace App\Livewire\User\Game;

use App\Models\Chess\Game;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    #[Layout('layouts.user')]
    public function render()
    {
        $user = auth()->user();
        $games = $user?->games()
            ->with(['white', 'black'])
            ->latest('id')
            ->paginate(10);

        return view('livewire.user.game.index', [
            'games' => $games,
        ]);
    }
}
