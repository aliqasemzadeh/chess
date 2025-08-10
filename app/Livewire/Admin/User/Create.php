<?php

namespace App\Livewire\Admin\User;

use App\Models\User;
use Illuminate\Validation\Rules\Password as PasswordRule;
use Livewire\Component;
use LivewireUI\Modal\ModalComponent;

class Create extends ModalComponent
{
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    protected function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', PasswordRule::defaults()],
        ];
    }

    public function save()
    {
        $data = $this->validate();
        $user = User::create($data);
        $this->dispatch('userSaved');
        session()->flash('message', __('User created successfully'));
        // Try to close modal (depends on modal package)
        $this->dispatch('closeModal');
        // Reset for next open
        $this->reset(['name', 'email', 'password', 'password_confirmation']);
    }

    public function render()
    {
        return view('livewire.admin.user.create');
    }
}
