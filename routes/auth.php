<?php

use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::middleware('guest')->group(function () {
    Route::get('/login', function () {
        return view('common.login');
    })->name('login');
});

Route::get('logout', App\Livewire\Actions\Logout::class)
    ->name('logout');
