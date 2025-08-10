<?php

Route::middleware('guest')->group(function () {

    Route::get('/login', App\Livewire\Guest\Auth\Login::class)->name('login');
    Route::get('/register', App\Livewire\Guest\Auth\Register::class)->name('register');
    Route::get('/logout', App\Livewire\Guest\Auth\Logout::class)->name('logout');

});
