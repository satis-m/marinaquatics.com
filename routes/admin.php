<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Redirect::to('/login');
});

Route::get('/login', function () {
    if (Auth::check()) {
        return Redirect::to('/dashboard');
    }

    return view('login');
})->name('login');

Route::get('/layout', function () {
    return Inertia::render('Admin/Layout');
})->name('layout');

//Route::get('dashboard', DashboardController::class)->name('user.dashboard');
