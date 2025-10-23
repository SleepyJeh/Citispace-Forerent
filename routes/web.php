<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Livewire\Volt\Volt;
use App\Http\Controllers\Admin\UnitController;

Route::get('/', function () {
    return view('common/index');
})->name('home');

Route::get('/login', function () {
    return view('common/login');
})->middleware('guest')->name('login');

Route::get('/dashboard', function () {
    return view('users/admin/owner/settings'); // This loads resources/views/settings.blade.php
})->middleware('auth')->name('settings'); // Make sure it's protected!

Route::get('/addunit', function () {
    return view('users/admin/addunit');
})->name('addunit');

Route::get('/revenue', function () {
    return view('users/admin/revenue');
})->name('revenue');
Route::get('/property', function () {
    return view('users/admin/property');
})->name('property');

require __DIR__ . '/auth.php';
