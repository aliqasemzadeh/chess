<?php

use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function() {
    Route::get('/', \App\Livewire\User\Game\Index::class)->name('dashboard');
    Route::get('/games', \App\Livewire\User\Game\Index::class)->name('user.games.index');
    Route::get('/games/play/{id}', \App\Livewire\User\Game\Play::class)->name('user.games.play');

    Route::prefix('admin')->group(function() {
        Route::get('/games', \App\Livewire\Admin\Game\Index::class)->name('admin.games.index');
        Route::get('/users', \App\Livewire\Admin\User\Index::class)->name('admin.users.index');
    });

    Route::any('/logout', \App\Livewire\Guest\Auth\Logout::class)->name('logout');
});

Route::get('/login', \App\Livewire\Guest\Auth\Login::class)->name('login');
Route::get('/register', \App\Livewire\Guest\Auth\Register::class)->name('register');
