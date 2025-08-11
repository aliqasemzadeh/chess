<?php

use Illuminate\Support\Facades\Route;


Route::middleware('auth')->group(function () {

    Route::get('/', App\Livewire\User\Dashboard\Index::class)->name('home');
    Route::get('/user/game/index', App\Livewire\User\Game\Index::class)->name('user.game.index');
    Route::get('/user/game/play/{id}', App\Livewire\User\Game\Play::class)->name('user.game.play');

    Route::get('/admin/dashboard/index', App\Livewire\Admin\Dashboard\Index::class)->name('admin.dashboard.index');
    Route::get('/admin/user/index', App\Livewire\Admin\User\Index::class)->name('admin.user.index');
    Route::get('/admin/game/index', App\Livewire\Admin\Game\Index::class)->name('admin.game.index');

});

require __DIR__.'/auth.php';
