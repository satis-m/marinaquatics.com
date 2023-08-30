<?php

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WishlistController;
use App\Models\Product;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    $products = Product::query()
//        ->where('sub_category', $subCategory)
        ->orderBy('slug')
        ->with('currentDiscount', 'category')
        ->get();
    //    dd($products);

    return Inertia::render('Home/Index', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
        'products' => $products,
    ]);
})->name('homepage');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard/Index');
})->middleware(['auth.client', 'verified'])->name('client.dashboard');

Route::middleware('auth.client')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/product/list/{subCategory}', [ProductController::class, 'list'])->name('product');
Route::get('/product/{slug}', [ProductController::class, 'view'])->name('product.view');
Route::get('/product/category/{slug}', [ProductController::class, 'categoryView'])->name('product.category.view');

Route::get('/user/wishlist', [WishlistController::class, 'index'])->name('user.wishlist.view');
Route::get('/user/cart', [CartController::class, 'index'])->name('user.cart.view');

Route::post('/login/send-otp', [RegisteredUserController::class, 'otpSend'])->name('register.optSend');
Route::post('/login/verify-otp', [RegisteredUserController::class, 'otpVerify'])->name('register.optVerify');
Route::post('/login/sign-up', [RegisteredUserController::class, 'store'])->name('registered.store');

require __DIR__.'/auth.php';
Route::fallback(fn () => abort('404'));
