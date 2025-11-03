<?php

use Illuminate\Support\Facades\Route;

Route::prefix('landing')->middleware('guest')->group(function () {
    // Home
    Route::get('/', function () {
        return view('landing.index');
    })->name('landing.home');

    // Features
    Route::get('/features', function () {
        return view('landing.features');
    })->name('landing.features');

    // About
    Route::get('/about', function () {
        return view('landing.about');
    })->name('landing.about');

    // Contacts
    Route::get('/contacts', function () {
        return view('landing.contacts');
    })->name('landing.contacts');
});
