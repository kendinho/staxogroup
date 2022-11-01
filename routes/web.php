<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StripePaymentController;

Auth::routes();

Route::resource('product', ProductController::class);

Route::controller(CatalogController::class)->group(function () {
    Route::get('/', 'index')->name('catalog');
    Route::get('/show/product/{id}', 'show')->name('show-product');
});

Route::controller(StripePaymentController::class)->group(function () {
    Route::get('/identify/buyer/{product}/{price}', 'collect_buyer_info')->name('collect-buyer-info');
    Route::post('/store/buyer/{product}/{price}', 'store_buyer')->name('store-buyer');
    Route::get('/payment/{id}/{product}/{price}', 'charge')->name('go-to-payment');
    Route::post('/process/payment/{product}/{price}', 'process_payment')->name('process-payment');
});
