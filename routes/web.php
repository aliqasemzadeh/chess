<?php

use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function() {
    Route::get('/', \App\Livewire\User\Game\Index::class)->name('dashboard');
    Route::get('/game/index', \App\Livewire\User\Game\Index::class)->name('home');
    Route::get('/game/play/{id}', \App\Livewire\User\Game\Play::class)->name('user.game.play');


    Route::prefix('admin')->group(function() {
        Route::get('/game/index', \App\Livewire\Admin\Game\Index::class)->name('admin.game.index');
        Route::get('/user/index', \App\Livewire\Admin\User\Index::class)->name('admin.user.index');
    });

    Route::any('/logout', \App\Livewire\Guest\Auth\Logout::class)->name('logout');
});

Route::get('/login', \App\Livewire\Guest\Auth\Login::class)->name('login');
Route::get('/register', \App\Livewire\Guest\Auth\Register::class)->name('register');
