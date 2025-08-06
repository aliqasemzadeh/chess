<?php

namespace App\Livewire\Guest\Auth;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Component;

class Login extends Component
{
    #[Layout('components.layouts.guest')]

    #[Rule('required|string|min:3')]
    public $username = '';

    #[Rule('required|string|min:6')]
    public $password = '';

    public $remember = false;

    public function login()
    {
        $validated = $this->validate();

        if (Auth::attempt(['name' => $validated['username'], 'password' => $validated['password']], $this->remember)) {
            session()->regenerate();

            return redirect()->intended(route('dashboard'));
        }

        session()->flash('error', 'The provided credentials do not match our records.');

        return null;
    }

    public function render()
    {
        return view('livewire.guest.auth.login');
    }
}
