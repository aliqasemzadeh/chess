<?php

namespace App\Livewire\Guest\Auth;

use Livewire\Attributes\Layout;
use Livewire\Component;

class Login extends Component
{
    #[Layout('layouts.guest')]
    public function render()
    {
        return view('livewire.guest.auth.login');
    }
}
