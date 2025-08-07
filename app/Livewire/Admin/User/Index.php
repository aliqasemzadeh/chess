<?php

namespace App\Livewire\Admin\User;

use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;
use WireUi\Traits\WireUiActions;

class Index extends Component
{
    use WireUiActions, WithPagination;

    public $search = '';
    public $perPage = 10;

    protected $listeners = ['userCreated', 'userUpdated'];

    #[Layout('components.layouts.admin')]
    public function render()
    {
        $users = User::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPage);

        return view('livewire.admin.user.index', compact('users'));
    }

    public function openCreateSlideOver()
    {
        $this->dispatch('slide-over.open', component: 'admin.user.create');
    }

    public function openEditSlideOver($userId)
    {
        $this->dispatch('slide-over.open', component: 'admin.user.edit', arguments: ['user' => $userId]);
    }

    public function deleteUser($userId)
    {
        $user = User::findOrFail($userId);
        $user->delete();
        
        $this->notification()->success(
            $title = 'کاربر حذف شد',
            $description = 'کاربر با موفقیت حذف شد'
        );
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedPerPage()
    {
        $this->resetPage();
    }
}
