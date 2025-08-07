<?php

namespace App\Livewire\User\Game;

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

    #[Layout('components.layouts.app')]
    public function render()
    {
        $games = Game::query()
            ->with(['whitePlayer', 'blackPlayer'])
            ->where(function ($query) {
                $query->where('white_player_id', auth()->id())
                    ->orWhere('black_player_id', auth()->id());
            })
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

        return view('livewire.user.game.index', compact('games'));
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
