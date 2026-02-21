<?php

use Illuminate\Support\Facades\Route;

Route::get('/', fn() => view('home.design12'))->name('home');

// Homepage design
Route::get('/12', fn() => view('home.design12'))->name('home.design12');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

require __DIR__ . '/settings.php';
