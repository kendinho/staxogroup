<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Auth::routes();

Route::resource('product', ProductController::class);

Route::controller(CatalogController::class)->group(function () {
    Route::get('/', 'index')->name('catalog');
    Route::get('/show/product/{id}', 'show')->name('show-product');
});

Route::controller(StripePaymentController::class)->group(function () {
    Route::get('/identify/buyer/{id}', 'collect_buyer_info')->name('collect-buyer-info');
    Route::post('/store/buyer/{id}', 'store_buyer')->name('store-buyer');
    Route::get('/payment/{id}/{product_id}', 'charge')->name('go-to-payment');
    Route::post('/process/payment/{id}', 'process_payment')->name('process-payment');
});
