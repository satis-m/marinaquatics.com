<?php

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomepageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductSearchController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WishlistController;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [HomepageController::class, 'index'])->name('homepage');

Route::middleware('auth.client', 'verified')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('client.dashboard');

    Route::patch('/user/personal-info', [DashboardController::class, 'updatePersonalInfo'])->name('client.personal-info.update');

    Route::patch('/user/shipping-info', [DashboardController::class, 'updateShippingInfo'])->name('client.shipping-info.update');

    Route::get('/order-list', [DashboardController::class, 'orderList'])->name('client.dashboard.order-history');
    Route::get('/shipping-address', [DashboardController::class, 'shippingAddress'])
        ->name('client.dashboard.shipping-address');
    Route::get('/change-password', [DashboardController::class, 'changePassword'])
        ->name('client.dashboard.change-password');

    Route::post('/cart/add', [CartController::class, 'store'])->name('user.cart.add');
    Route::delete('/cart/remove', [CartController::class, 'destroy'])->name('user.cart.remove');
    Route::patch('/cart/update', [CartController::class, 'update'])->name('user.cart.update');
    Route::post('/cart/confirm-order', [CartController::class, 'confirmOrder'])->name('user.cart.confirm-order');

    Route::delete('/order/cancel', [CartController::class, 'cancelOrder'])->name('user.order.cancel');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
    Route::post('/cart/proceed-payment', [CartController::class, 'proceedPayment'])->name('cart.proceed-payment');
    Route::post('/cart/success-payment', [CartController::class, 'succeedPayment']);
});

Route::get('/product/search', ProductSearchController::class)->name('product.search');
Route::get('/product/{slug}', [ProductController::class, 'view'])->name('product.view');
Route::get('/product/category/{slug}', [ProductController::class, 'categoryView'])->name('product.category.view');
Route::get('/product/type/{category}/{slug}', [ProductController::class, 'typeView'])->name('product.type.view');
Route::get('/product/brand/{slug}', [ProductController::class, 'brandView'])->name('product.brand.view');
Route::get('/product/tag/{slug}', [ProductController::class, 'tagView'])->name('product.tag.view');
Route::get('/user/wishlist', [WishlistController::class, 'index'])->name('user.wishlist.view');
Route::get('/user/cart', [CartController::class, 'index'])->name('user.cart.view');

Route::middleware('throttle:6,1')->group(function () {
    Route::post('/login/send-otp', [RegisteredUserController::class, 'otpSend'])->name('register.optSend');
    Route::post('/login/verify-otp', [RegisteredUserController::class, 'otpVerify'])->name('register.optVerify');
    Route::post('/login/reset-password/send-otp', [RegisteredUserController::class, 'resetPasswordOtpSend'])->name('reset-password.optSend');
    Route::post('/login/reset-password/verify-otp', [RegisteredUserController::class, 'resetPasswordOtpVerify'])->name('reset-password.optVerify');

    Route::post('/login/reset-password', [RegisteredUserController::class, 'resetPassword'])->name('reset-password');
    Route::post('/login/sign-up', [RegisteredUserController::class, 'store'])->name('registered.store');
});
Route::get('/payment/qr', function () {
    $path = storage_path('/required/shop-payment-info.jpg');

    // Check if the file exists
    if (File::exists($path)) {
        // Get the file content
        $fileContent = File::get($path);

        // Get the file mime type
        $fileType = File::mimeType($path);

        // Return the image as a response
        return Response::make($fileContent, 200, [
            'Content-Type' => $fileType,
            'Content-Disposition' => 'inline; filename="payment-info.jpg"',
        ]);
    }

    return 'no-payment';
})->name('qr.payment');

require __DIR__.'/auth.php';
require __DIR__.'/blog.php';
Route::fallback(fn () => abort('404'));

Route::get('/cache-clear/{cacheKey}/{passkey}', function ($cacheKey, $passkey) {
    if ($passkey == 'clear') {
        switch ($cacheKey) {
            case 'category':
                Cache::forget('Category');
                break;
            case 'productCategory':
                Cache::forget('productCategory');
                break;
            case 'productType':
                Cache::forget('productType');
                break;
            case 'appInfo':
                Cache::forget('ApplicationInfo');
                break;
            case 'all':
                Cache::forget('Category');
                Cache::forget('productCategory');
                Cache::forget('productType');
                Cache::forget('ApplicationInfo');
                break;
            default:
                echo 'Bad cache request';
                break;
        }
    } else {
        echo 'Bad pass request';
    }
});
Route::get('test', function () {
    $userEmail = 'maharjan.hardcore@gmail.com';

    $otpCode = otpGenerate(); // You need to implement a function to generate the verification code.
    $orderInfo = (object) [
        'orderNo' => 'orderNo',
        'orderAmount' => 'orderAmount',
        'deliveryType' => 'deliveryType',
        'paymentMethod' => 'paymentMethod',
    ];
    //    Mail::to(env('ADMIN_MAIL'))->send(new NewOrderEmail($orderInfo));
    // Send the email
    // Mail::to($userEmail)->send(new OtpCodeEmail($orderInfo));
    return view('emails.send-otp', ['otpCode' => 'fsdf']);

    return 'otp-sent';
});
