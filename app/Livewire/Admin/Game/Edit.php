<?php

namespace App\Livewire\Admin\Game;

use App\Models\Chess\Game;
use App\Models\User;
use Livewire\Component;
use WireElements\Pro\Components\SlideOver\SlideOver;
use WireUi\Traits\WireUiActions;

class Edit extends SlideOver
{
    use WireUiActions;

    public $gameId;
    public $game;
    public $white_player_id = '';
    public $black_player_id = '';
    public $status = '';
    public $result = '';
    public $start_at = '';
    public $end_at = '';

    public function mount($game)
    {
        $this->gameId = $game;
        $this->game = Game::findOrFail($game);
        $this->white_player_id = $this->game->white_player_id;
        $this->black_player_id = $this->game->black_player_id;
        $this->status = $this->game->status;
        $this->result = $this->game->result;
        $this->start_at = $this->game->start_at?->format('Y-m-d\TH:i');
        $this->end_at = $this->game->end_at?->format('Y-m-d\TH:i');
    }

    protected function rules()
    {
        return [
            'white_player_id' => 'required|exists:users,id',
            'black_player_id' => 'required|exists:users,id|different:white_player_id',
            'status' => 'required|in:pending,active,completed,abandoned',
            'result' => 'nullable|in:white_win,black_win,draw',
            'start_at' => 'nullable|date',
            'end_at' => 'nullable|date|after:start_at',
        ];
    }

    protected function messages()
    {
        return [
            'white_player_id.required' => 'انتخاب بازیکن سفید الزامی است',
            'white_player_id.exists' => 'بازیکن سفید انتخاب شده معتبر نیست',
            'black_player_id.required' => 'انتخاب بازیکن سیاه الزامی است',
            'black_player_id.exists' => 'بازیکن سیاه انتخاب شده معتبر نیست',
            'black_player_id.different' => 'بازیکن سفید و سیاه نمی‌توانند یکسان باشند',
            'status.required' => 'وضعیت بازی الزامی است',
            'status.in' => 'وضعیت بازی معتبر نیست',
            'result.in' => 'نتیجه بازی معتبر نیست',
            'start_at.date' => 'تاریخ شروع معتبر نیست',
            'end_at.date' => 'تاریخ پایان معتبر نیست',
            'end_at.after' => 'تاریخ پایان باید بعد از تاریخ شروع باشد',
        ];
    }

    public function save()
    {
        $this->validate();

        $this->game->update([
            'white_player_id' => $this->white_player_id,
            'black_player_id' => $this->black_player_id,
            'status' => $this->status,
            'result' => $this->result,
            'start_at' => $this->start_at ? now()->parse($this->start_at) : null,
            'end_at' => $this->end_at ? now()->parse($this->end_at) : null,
        ]);

        $this->notification()->success(
            $title = 'بازی بروزرسانی شد',
            $description = 'اطلاعات بازی با موفقیت بروزرسانی شد'
        );

        $this->close(andDispatch: ['gameUpdated']);
    }

    public function render()
    {
        $users = User::orderBy('name')->get();
        return view('livewire.admin.game.edit', compact('users'));
    }
}
