<?php

use App\Http\Controllers\Admin\AppSettingController;
use App\Http\Controllers\Admin\AuthenticateAdminController;
use App\Http\Controllers\Admin\ManageProductController;
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

    Route::resource('manage/product', ManageProductController::class);
    Route::delete('manage/product/picture/{id}', [ManageProductController::class, 'deletePicture'])->name('manage.product.picture');

    Route::prefix('manage/product-import')->group(function () {
        Route::post('{productId}', [ManageProductController::class, 'addImport'])->name('manage.product-import.store');
        Route::patch('{productId}/{id}', [ManageProductController::class, 'updateImport'])->name('manage.product-import.update');
    });

    Route::prefix('manage/product-damage')->group(function () {
        Route::post('{productId}', [ManageProductController::class, 'addDamage'])->name('manage.product-damage.store');
        Route::patch('{productId}/{id}', [ManageProductController::class, 'updateDamage'])->name('manage.product-damage.update');
    });

    Route::delete('importer/{name}', function ($name) {
        return \App\Models\Importer::where('name', $name)->delete();
    })->name('importer');
});

require __DIR__.'/axios.php';
