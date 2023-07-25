<?php

use App\Http\Controllers\Admin\AppSettingController;
use App\Http\Controllers\Admin\AuthenticateAdminController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductDamageController;
use App\Http\Controllers\Admin\ProductDiscountController;
use App\Http\Controllers\Admin\ProductImportController;
use App\Http\Controllers\Admin\ProductOfferController;
use App\Http\Controllers\Admin\TrashController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

Route::get('/', function () {
    return Redirect::to('/admin/login');
});

Route::get('/login', function () {
    if (Auth::guard('admin')->check()) {

        return Redirect::to(route('admin.dashboard'));
    }
    Inertia::setRootView('adminApp');

    return Inertia::render('Login');
})->name('admin.login');

Route::post('/login', [AuthenticateAdminController::class, 'store'])->name('admin.login');
Route::post('/logout', [AuthenticateAdminController::class, 'destroy'])->name('admin.logout');

Route::middleware('auth.admin')->group(function () {

    Route::get('/dashboard', DashboardController::class)->name('admin.dashboard');

    Route::prefix('app-setting')->group(function () {
        Route::get('/', [AppSettingController::class, 'index'])->name('appSetting.index');
        Route::patch('update', [AppSettingController::class, 'update'])->name('appSetting.update');
    });

    Route::resource('manage/product', ProductController::class);
    Route::delete('manage/product/picture/{mediaId}', [ProductController::class, 'deletePicture'])->name('manage.product.picture');

    Route::prefix('product-import')->group(function () {
        Route::post('{productId}', [ProductImportController::class, 'store'])->name('product-import.store');
        Route::patch('{productId}/{importId}', [ProductImportController::class, 'update'])->name('product-import.update');
    });

    Route::prefix('product-damage')->group(function () {
        Route::post('{productId}', [ProductDamageController::class, 'store'])->name('product-damage.store');
        Route::patch('{productId}/{damageId}', [ProductDamageController::class, 'update'])->name('product-damage.update');
    });

    Route::patch('product-offer/{productId}', [ProductOfferController::class, 'update'])->name('product-offer.update');

    Route::post('product-offer/{productId}', [ProductDiscountController::class, 'store'])->name('product-discount.store');
    Route::patch('product-offer/{productId}/{discountId}', [ProductDiscountController::class, 'update'])->name('product-discount.update');

    Route::get('trash', [TrashController::class, 'index'])->name('trash.index');
    Route::patch('trash/product/{productId}', [TrashController::class, 'productRestore'])->name('trash.product.restore');
    Route::delete('trash/product/{productId}', [TrashController::class, 'productDestroy'])->name('trash.product.destroy');

    Route::delete('importer/{name}', function ($name) {
        return \App\Models\Importer::where('name', $name)->delete();
    })->name('importer');

    Route::get('reset-permission', function () {
        app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
        // create permissions
        DB::table('role_has_permissions')->truncate();
        DB::table('permissions')->delete();
        $permissionList = File::get(base_path('/storage/required/PermissionList.json'));
        $defaultPermissions = json_decode($permissionList);
        $permissions = [
            'Impersonate-create',
            'Impersonate-delete',
            ...$defaultPermissions,
        ];
        foreach ($permissions as $permission) {
            Permission::create([
                'name' => $permission,
                'guard_name' => 'admin',
            ]);
        }
        // gets all permissions via Gate::before rule; see AuthServiceProvider
        //Role::create(['name' => 'Super-Admin']);
        $role = Role::where('name', 'admin')->first();
        $adminPermissions = [
            'Impersonate-create',
            'Impersonate-delete',
            ...$defaultPermissions,
        ];
        foreach ($adminPermissions as $permission) {
            $role->givePermissionTo($permission);
        }

        $developerPermissions = [
            'Impersonate-create',
            'Impersonate-delete',
            ...$defaultPermissions,
        ];
        $developerRole = Role::where('name', 'developer')->first();
        foreach ($developerPermissions as $permission) {
            $developerRole->givePermissionTo($permission);
        }

    });
});

require __DIR__.'/axios.php';
