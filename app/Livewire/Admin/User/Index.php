<?php

namespace App\Livewire\Admin\User;

use Livewire\Attributes\Layout;
use Livewire\Component;
use WireUi\Traits\WireUiActions;

class Index extends Component
{
    use WireUiActions;

    #[Layout('components.layouts.admin')]
    public function render()
    {
        return view('livewire.admin.user.index');
    }
}
