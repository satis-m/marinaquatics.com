<?php

use App\Http\Controllers\Admin\AuthenticateAdminController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Redirect::to('/login');
});

Route::get('/login', function () {
    if (Auth::check() && in_array(Auth::user()->role, ['admin', 'developer'])) {
        return Redirect::to('/dashboard');
    }

    return Inertia::render('Admin/Login');
})->name('admin.login');

Route::post('/login', [AuthenticateAdminController::class, 'store'])->name('admin.login');

Route::get('/layout', function () {
    return Inertia::render('Admin/Layout');
})->name('layout');

//Route::get('dashboard', DashboardController::class)->name('user.dashboard');
