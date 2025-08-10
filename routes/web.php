<?php

use Illuminate\Support\Facades\Route;


Route::middleware('auth')->group(function () {

    Route::get('/', App\Livewire\User\Dashboard\Index::class);
    Route::get('/game/index', App\Livewire\User\Game\Index::class);

    Route::get('/admin/dashboard/index', App\Livewire\Admin\Dashboard\Index::class);
    Route::get('/admin/user/index', App\Livewire\Admin\User\Index::class);
    Route::get('/admin/game/index', App\Livewire\Admin\Game\Index::class);

});

require __DIR__.'/auth.php';
