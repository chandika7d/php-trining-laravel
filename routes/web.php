<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::middleware(['auth', 'web'])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::resource('user',App\Http\Controllers\UserController::class);
    Route::resource('sizes',App\Http\Controllers\SizesController::class);
    Route::resource('colors',App\Http\Controllers\ColorsController::class);
    Route::resource('brands',App\Http\Controllers\BrandsController::class);
    Route::resource('cuttings',App\Http\Controllers\CuttingsController::class);
    Route::resource('ocassions',App\Http\Controllers\OcassionsController::class);
    Route::resource('banner_category',App\Http\Controllers\BannerCategoryController::class);
    Route::resource('banner',App\Http\Controllers\BannerController::class);
    Route::resource('faq',App\Http\Controllers\FaqController::class);
    Route::resource('produk_category',App\Http\Controllers\ProdukCategoryController::class);
});