<?php

use App\Http\Controllers\Admin\AppSettingController;
use App\Http\Controllers\Admin\AuthenticateAdminController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Redirect::to('/admin/login');
});

Route::get('/login', function () {

    if (Auth::guard('admin')->check()) {
        return Redirect::to(route('admin.dashboard'));
    }
    Inertia::setRootView('adminApp');

    return Inertia::render('Admin/Login');
})->name('admin.login');

Route::post('/login', [AuthenticateAdminController::class, 'store'])->name('admin.login');
Route::post('/logout', [AuthenticateAdminController::class, 'destroy'])->name('admin.logout');

Route::middleware('auth.admin')->group(function () {
    Route::get('/layout', function () {
        return Inertia::render('Admin/Layout');
    })->name('layout');
    Route::get('/dashboard', function () {
        return Inertia::render('Admin/Layout');
    })->name('admin.dashboard');

    Route::prefix('app-setting')->group(function () {
        Route::get('/', [AppSettingController::class, 'index'])->name('appSetting.index');
        Route::patch('update', [AppSettingController::class, 'update'])->name('appSetting.update');
    });

});
