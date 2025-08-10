<?php

namespace App\Livewire\Admin\User;

use App\Models\User;
use Illuminate\Validation\Rules\Password as PasswordRule;
use Livewire\Component;

class Edit extends Component
{
    public ?User $user = null;
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    public function mount(?int $userId = null)
    {
        if ($userId) {
            $this->user = User::findOrFail($userId);
            $this->name = (string) $this->user->name;
            $this->email = (string) $this->user->email;
        }
    }

    protected function rules(): array
    {
        $id = $this->user?->id ?? 'NULL';
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', "unique:users,email,{$id}"],
            'password' => ['nullable', 'confirmed', PasswordRule::defaults()],
        ];
    }

    public function update()
    {
        $data = $this->validate();
        $this->user->name = $data['name'];
        $this->user->email = $data['email'];
        if (!empty($data['password'] ?? '')) {
            $this->user->password = $data['password'];
        }
        $this->user->save();

        $this->dispatch('userSaved');
        session()->flash('message', __('User updated successfully'));
        $this->dispatch('closeModal');
    }

    public function render()
    {
        return view('livewire.admin.user.edit');
    }
}
