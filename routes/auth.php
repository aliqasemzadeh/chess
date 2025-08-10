<?php

Route::middleware('guest')->group(function () {

    Route::get('/login', App\Livewire\Guest\Auth\Login::class);
    Route::get('/register', App\Livewire\Guest\Auth\Register::class);
    Route::get('/logout', App\Livewire\Guest\Auth\Logout::class);

});
