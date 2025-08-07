<?php

namespace App\Livewire\Admin\Game;

use App\Models\Chess\Game;
use App\Models\User;
use Livewire\Component;
use WireElements\Pro\Components\SlideOver\SlideOver;
use WireUi\Traits\WireUiActions;

class Create extends SlideOver
{
    use WireUiActions;

    public $white_player_id = '';
    public $black_player_id = '';
    public $status = 'pending';
    public $start_at = '';
    public $end_at = '';

    protected function rules()
    {
        return [
            'white_player_id' => 'required|exists:users,id',
            'black_player_id' => 'required|exists:users,id|different:white_player_id',
            'status' => 'required|in:pending,active,completed,abandoned',
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
            'start_at.date' => 'تاریخ شروع معتبر نیست',
            'end_at.date' => 'تاریخ پایان معتبر نیست',
            'end_at.after' => 'تاریخ پایان باید بعد از تاریخ شروع باشد',
        ];
    }

    public function save()
    {
        $this->validate();

        Game::create([
            'white_player_id' => $this->white_player_id,
            'black_player_id' => $this->black_player_id,
            'status' => $this->status,
            'start_at' => $this->start_at ? now()->parse($this->start_at) : null,
            'end_at' => $this->end_at ? now()->parse($this->end_at) : null,
        ]);

        $this->notification()->success(
            $title = 'بازی ایجاد شد',
            $description = 'بازی جدید با موفقیت ایجاد شد'
        );

        $this->close(andDispatch: ['gameCreated']);
    }

    public function render()
    {
        $users = User::orderBy('name')->get();
        return view('livewire.admin.game.create', compact('users'));
    }
}
