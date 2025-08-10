<?php

namespace App\Livewire\Guest\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Register extends Component
{
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';
    public bool $terms = false;

    #[Layout('layouts.guest')]
    public function render()
    {
        return view('livewire.guest.auth.register');
    }

    public function mount(): void
    {
        if (Auth::check()) {
            $this->redirectIntended('/');
        }
    }

    protected function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'terms' => ['required', 'accepted'],
        ];
    }

    protected function messages(): array
    {
        return [
            'name.required' => __('The name field is required.'),
            'name.max' => __('The name may not be greater than 255 characters.'),
            'email.required' => __('The email field is required.'),
            'email.email' => __('Please enter a valid email address.'),
            'email.unique' => __('This email address is already registered.'),
            'password.required' => __('The password field is required.'),
            'password.min' => __('The password must be at least 8 characters.'),
            'password.confirmed' => __('The password confirmation does not match.'),
            'terms.required' => __('You must accept the terms and conditions.'),
            'terms.accepted' => __('You must accept the terms and conditions.'),
        ];
    }

    public function register(): void
    {
        $validated = $this->validate();

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        Auth::login($user);
        request()->session()->regenerate();

        $this->redirectIntended('/');
    }
}
