<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Features;
use Livewire\Volt\Volt;
use App\Http\Controllers\Admin\UnitController;
use App\Http\Controllers\PropertyController;

Route::get('/', function () {
    $user = Auth::user();

    if (!$user) {
        return redirect()->route('login');
    }

    return match ($user->role) {
        'landlord' => redirect()->route('landlord.dashboard'),
        'manager'  => redirect()->route('manager.dashboard'),
        'tenant'   => redirect()->route('tenant.dashboard'),
        default    => redirect()->route('login'),
    };
})->name('home');






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

// Messages
Route::get('/messages', function () {
    return view('users.messages');
})->name('message');

// Settings
Route::get('/settings', function () {
    return view('users.settings');
})->middleware('auth')->name('settings');

require __DIR__ . '/auth.php';
require __DIR__ . '/modules/landing.php';
require __DIR__ . '/modules/landlord.php';
require __DIR__ . '/modules/manager.php';
require __DIR__ . '/modules/tenant.php';
