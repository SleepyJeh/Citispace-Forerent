<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Livewire\Volt\Volt;
use App\Http\Controllers\Admin\UnitController;
use App\Http\Controllers\PropertyController;

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
    return view('users/admin/owner/revenue');
})->name('revenue');

Route::get('/manager', function () {
    return view('users/admin/owner/managerdetails');
})->name('manager');

Route::get('/property', function () {
    return view('users/admin/property');
})->name('property');
Route::middleware('auth')->group(function () {
    // ... your other routes

    // This route shows the list of properties (the page you uploaded)
    Route::get('/property', [PropertyController::class, 'index'])->name('properties.index');

    // This route will show the "Add Property" form (we can build this next)
    Route::get('/properties/create', [PropertyController::class, 'create'])->name('properties.create');
});

Route::get('/revenue', function () {
    return view('users.admin.owner.revenue');
})->name('revenue');

require __DIR__ . '/auth.php';

// The extra '}' has been removed.
