<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\BlogSearchController;

Route::middleware('web')->group(function () {
    Route::get('blog', function () {
        return Redirect::to('blog/category/all');
    });
    Route::get('blog/category/{category?}', [BlogController::class, 'index'])
        ->name('blog.index');
    Route::get('blog/search', BlogSearchController::class)
        ->name('blog.search');
    Route::get('blog/{slug}', [BlogController::class, 'view'])
        ->name('blog.view');
});
