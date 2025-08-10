<?php

namespace App\Livewire\Guest\Auth;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Logout extends Component
{
    #[Layout('layouts.guest')]
    public function render()
    {
        return view('livewire.guest.auth.logout');
    }

    public function mount(): void
    {
        if (Auth::check()) {
            Auth::logout();
            request()->session()->invalidate();
            request()->session()->regenerateToken();
            
            $this->redirect(route('login'));
        } else {
            $this->redirect(route('login'));
        }
    }
}
