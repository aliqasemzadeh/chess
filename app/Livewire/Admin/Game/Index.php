<?php

namespace App\Livewire\Admin\Game;

use App\Models\Chess\Game;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;
use WireUi\Traits\WireUiActions;

class Index extends Component
{
    use WireUiActions, WithPagination;

    public $search = '';
    public $perPage = 10;
    public $statusFilter = '';

    protected $listeners = ['gameCreated', 'gameUpdated'];

    #[Layout('components.layouts.admin')]
    public function render()
    {
        $games = Game::query()
            ->with(['whitePlayer', 'blackPlayer'])
            ->when($this->search, function ($query) {
                $query->whereHas('whitePlayer', function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%');
                })->orWhereHas('blackPlayer', function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->statusFilter, function ($query) {
                $query->where('status', $this->statusFilter);
            })
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPage);

        return view('livewire.admin.game.index', compact('games'));
    }

    public function openCreateSlideOver()
    {
        $this->dispatch('slide-over.open', component: 'admin.game.create');
    }

    public function openEditSlideOver($gameId)
    {
        $this->dispatch('slide-over.open', component: 'admin.game.edit', arguments: ['gameId' => $gameId]);
    }

    public function deleteGame($gameId)
    {
        $game = Game::findOrFail($gameId);
        $game->delete();

        $this->notification()->success(
            $title = 'بازی حذف شد',
            $description = 'بازی با موفقیت حذف شد'
        );
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedStatusFilter()
    {
        $this->resetPage();
    }

    public function updatedPerPage()
    {
        $this->resetPage();
    }
}
