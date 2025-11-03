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
    return view('users/admin/owner/settings');
})->middleware('auth')->name('settings');

Route::get('/dashboard', function () {
    return view('users/admin/owner/dashboard');
})->name('dashboard');

Route::get('/addunit', function () {
    return view('users/admin/addunit');
})->name('addunit');

Route::get('/revenue', function () {
    return view('users/admin/owner/revenue');
})->name('revenue');

Route::get('/manager', function () {
    return view('users/admin/owner/managerdetails');
})->name('manager');

Route::get('/property', function () {
    return view('users/admin/property');
})->name('property');

Route::get('/revenue', function () {
    return view('users/admin/owner/revenue');
})->name('revenue');

require __DIR__ . '/auth.php';

// The extra '}' has been removed.
