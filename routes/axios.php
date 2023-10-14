<?php

Route::prefix('axios')->middleware('auth.admin')->group(function () {
    Route::get('product/{slug}/import-list/all', function ($slug) {
        $importList = \App\Models\ProductImport::where('product_slug', $slug)->latest('id')->get()->toArray();

        return Response::json(['results' => $importList]);
    })->name('product.import-list.all');

    Route::get('product/{slug}/import-list/latest', function ($slug) {
        $importList = \App\Models\ProductImport::where('product_slug', $slug)->latest('id')->take(5)->get()->toArray();

        return Response::json(['results' => $importList]);
    })->name('product.import-list.latest');
    Route::get('product/{slug}/damage-list/all', function ($slug) {
        $importList = \App\Models\ProductDamage::where('product_slug', $slug)->latest('id')->get()->toArray();

        return Response::json(['results' => $importList]);
    })->name('product.damage-list.all');

    Route::get('product/{slug}/damage-list/latest', function ($slug) {
        $importList = \App\Models\ProductDamage::where('product_slug', $slug)->latest('id')->take(5)->get()->toArray();

        return Response::json(['results' => $importList]);
    })->name('product.damage-list.latest');

    Route::get('product/{slug}/discount/latest', function ($slug) {
        $importList = \App\Models\Discount::where('product_slug', $slug)->latest('id')->take(5)->get()->toArray();

        return Response::json(['results' => $importList]);
    })->name('product.discount.latest');
});
