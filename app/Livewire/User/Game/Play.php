<?php

namespace App\Livewire\User\Game;

use Livewire\Component;
use WireUi\Traits\WireUiActions;

class Play extends Component
{
    use WireUiActions;
    public function render()
    {
        return view('livewire.user.game.play');
    }
}
