<?php

namespace App\Livewire\User\Game;

use Livewire\Attributes\Layout;
use Livewire\Component;
use WireUi\Traits\WireUiActions;

class Index extends Component
{
    use WireUiActions;

    #[Layout('components.layouts.app')]
    public function render()
    {
        return view('livewire.user.game.index');
    }
}
