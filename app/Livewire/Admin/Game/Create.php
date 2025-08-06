<?php

namespace App\Livewire\Admin\Game;

use Livewire\Component;
use WireElements\Pro\Components\SlideOver\SlideOver;

class Create extends SlideOver
{
    public function render()
    {
        return view('livewire.admin.game.create');
    }
}
