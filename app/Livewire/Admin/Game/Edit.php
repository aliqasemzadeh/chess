<?php

namespace App\Livewire\Admin\Game;

use Livewire\Component;
use WireElements\Pro\Components\SlideOver\SlideOver;
use WireUi\Traits\WireUiActions;

class Edit extends SlideOver
{
    use WireUiActions;
    public function render()
    {
        return view('livewire.admin.game.edit');
    }
}
