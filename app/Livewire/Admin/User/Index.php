<?php

namespace App\Livewire\Admin\User;

use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public string $search = '';
    public int $perPage = 10;

    protected $queryString = [
        'search' => ['except' => ''],
    ];

    #[Layout('layouts.admin')]
    public function render()
    {
        return view('livewire.admin.user.index', [
            'users' => $this->users,
        ]);
    }

    public function getUsersProperty()
    {
        return User::query()
            ->when($this->search !== '', function ($q) {
                $term = "%{$this->search}%";
                $q->where(function ($qq) use ($term) {
                    $qq->where('name', 'like', $term)
                       ->orWhere('email', 'like', $term);
                });
            })
            ->latest('id')
            ->paginate($this->perPage);
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    #[On('userSaved')]
    public function refreshList()
    {
        // Re-render to refresh the list after create/update
    }

    public function openCreateModal()
    {
        // Dispatch event that livewire-modal package listens to
        $this->dispatch('openModal', component: 'admin.user.create');
    }

    public function openEditModal(int $userId)
    {
        $this->dispatch('openModal', component: 'admin.user.edit', arguments: ['userId' => $userId]);
    }

    public function delete(int $userId)
    {
        $user = User::find($userId);
        if (!$user) {
            session()->flash('message', __('Not Found'));
            return;
        }
        $user->delete();
        session()->flash('message', __('User deleted successfully'));
        // Optionally, adjust page if becomes empty
        if ($this->users->isEmpty() && $this->page > 1) {
            $this->previousPage();
        }
    }
}
