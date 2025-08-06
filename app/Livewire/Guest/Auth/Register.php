<?php

namespace App\Livewire\Guest\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Rule;
use Livewire\Component;

class Register extends Component
{
    #[Layout('components.layouts.guest')]

    #[Rule('required|string|min:3|max:255')]
    public $name = '';

    #[Rule('required|email|unique:users,email')]
    public $email = '';

    #[Rule('required|string|min:6|confirmed')]
    public $password = '';

    #[Rule('required|string|min:6')]
    public $password_confirmation = '';

    public function register()
    {
        $validated = $this->validate();

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        Auth::login($user);

        session()->regenerate();

        return redirect()->intended(route('dashboard'));
    }

    public function render()
    {
        return view('livewire.guest.auth.register');
    }
}
