<?php

namespace App\Livewire\Guest\Auth;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Login extends Component
{
    public string $email = '';
    public string $password = '';

    #[Layout('layouts.guest')]
    public function render()
    {
        return view('livewire.guest.auth.login');
    }

    public function mount(): void
    {
        if (Auth::check()) {
            // If already authenticated, redirect to intended location or dashboard
            $this->redirectIntended('/');
        }
    }

    protected function rules(): array
    {
        return [
            'email' => ['required', 'email'],
            'password' => ['required'],
        ];
    }

    public function login()
    {
        $validated = $this->validate();

        if (Auth::attempt(['email' => $validated['email'], 'password' => $validated['password']], false)) {
            request()->session()->regenerate();
            return $this->redirectIntended('/');
        }

        // Authentication failed
        $this->addError('email', __('These credentials do not match our records.'));
        // For security, do not preserve the password in memory/UI
        $this->password = '';
    }
}
