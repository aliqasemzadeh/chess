<?php

namespace App\Livewire\Guest\Auth;

use Livewire\Attributes\Layout;
use Livewire\Component;

class Logout extends Component
{
    #[Layout('layouts.guest')]
    public function render()
    {
        return view('livewire.guest.auth.logout');
    }
}
