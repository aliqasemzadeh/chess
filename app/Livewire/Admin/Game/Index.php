<?php

namespace App\Livewire\Admin\Game;

use App\Models\Chess\Game;
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
        return view('livewire.admin.game.index', [
            'games' => $this->games,
        ]);
    }

    public function getGamesProperty()
    {
        return Game::query()
            ->with(['white', 'black'])
            ->when($this->search !== '', function ($q) {
                $term = "%{$this->search}%";
                $q->whereHas('white', function ($qq) use ($term) {
                    $qq->where('name', 'like', $term)->orWhere('email', 'like', $term);
                })->orWhereHas('black', function ($qq) use ($term) {
                    $qq->where('name', 'like', $term)->orWhere('email', 'like', $term);
                });
            })
            ->latest('id')
            ->paginate($this->perPage);
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    #[On('gameSaved')]
    public function refreshList()
    {
        // Re-render
    }

    public function openCreateModal()
    {
        $this->dispatch('openModal', component: 'admin.game.create');
    }

    public function openEditModal(int $gameId)
    {
        $this->dispatch('openModal', component: 'admin.game.edit', arguments: ['gameId' => $gameId]);
    }

    public function delete(int $gameId)
    {
        $game = Game::find($gameId);
        if (!$game) {
            session()->flash('message', __('Not Found'));
            return;
        }
        $game->delete();
        session()->flash('message', __('Game deleted successfully'));
        if ($this->games->isEmpty() && $this->page > 1) {
            $this->previousPage();
        }
    }
}
