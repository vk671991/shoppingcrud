<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::group(['prefix' => 'shop-shop','as'=>'api.'], function(){
    Route::group(['prefix' => 'products'], function(){
        Route::get('/', [\App\Http\Controllers\API\ProductController::class, 'index'])->name('product.list');
        Route::get('/{slug}', [\App\Http\Controllers\API\ProductController::class, 'show'])->name('product.get');
        Route::post('/create', [\App\Http\Controllers\API\ProductController::class, 'store'])->name('product.create');
        Route::post('/{slug}/update', [\App\Http\Controllers\API\ProductController::class, 'update'])->name('product.update');
        Route::post('/{slug}/delete', [\App\Http\Controllers\API\ProductController::class, 'destroy'])->name('product.delete');
    });
    Route::get('product-categories', [\App\Http\Controllers\API\ProductController::class, 'getProductCategories'])->name('product-category.list');
});
