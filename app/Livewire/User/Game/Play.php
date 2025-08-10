<?php

namespace App\Livewire\User\Game;

use Livewire\Attributes\Layout;
use Livewire\Component;

class Play extends Component
{
    #[Layout('layouts.user')]
    public function render()
    {
        return view('livewire.user.game.play');
    }
}
