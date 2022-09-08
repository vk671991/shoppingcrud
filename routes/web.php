<?php

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
Route::get('/', [\App\Http\Controllers\FrontEnd\ProductController::class, 'index'])->name('home');
Route::group(['prefix' => 'shop-backend','as'=>'backend.'], function(){
    Route::get('/', [\App\Http\Controllers\BackEnd\ProductController::class, 'index'])->name('product.list');
    Route::get('/create', [\App\Http\Controllers\BackEnd\ProductController::class, 'create'])->name('product.create');
    Route::get('/{slug}/edit', [\App\Http\Controllers\BackEnd\ProductController::class, 'edit'])->name('product.edit');
});

