<?php

namespace App\Livewire\Admin\Game;

use Livewire\Component;
use LivewireUI\Modal\ModalComponent;

class Create extends ModalComponent
{
    public function render()
    {
        return view('livewire.admin.game.create');
    }
}
