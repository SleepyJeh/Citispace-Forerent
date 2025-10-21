<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Livewire\Volt\Volt;
use App\Http\Controllers\Admin\UnitController;

Route::get('/', function () {
    return view('common/index');
})->name('home');

Route::get('/user-login', function () {
    return view('common/login');
})->name('user-login');


Route::get('/addunit', function () {
    return view('users/admin/addunit');
})->name('addunit');

Route::get('/revenue', function () {
    return view('users/admin/revenue');
})->name('revenue');
Route::get('/property', function () {
    return view('users/admin/property');
})->name('property');

require __DIR__.'/auth.php';





