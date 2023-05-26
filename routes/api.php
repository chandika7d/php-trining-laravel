<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ColorController;
use App\Http\Controllers\API\BrandController;
use App\Http\Controllers\API\SizeController;
use App\Http\Controllers\API\CuttingController;
use App\Http\Controllers\API\OcassionController;
use App\Http\Controllers\API\BannerCategoryController;
use App\Http\Controllers\API\BannerController;
use App\Http\Controllers\API\ConfigController;
use App\Http\Controllers\API\BankController;
use App\Http\Controllers\API\ProductCategoryController;
use App\Http\Controllers\API\FaqController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});


Route::post('/auth/get-token', [AuthController::class, "getToken"]);


Route::middleware(['auth', 'web'])->group(function () {
    Route::apiResource('colors', ColorController::class);
    Route::apiResource('brands', BrandController::class);
    Route::apiResource('sizes', SizeController::class);
    Route::apiResource('cuttings', CuttingController::class);
    Route::apiResource('ocassions', OcassionController::class);
    Route::apiResource('banner-categories', BannerCategoryController::class);
    Route::apiResource('banners', BannerController::class);
    Route::apiResource('configs', ConfigController::class);
    Route::apiResource('banks', BankController::class);
    Route::apiResource('faqs', FaqController::class);
    Route::apiResource('product-categories', ProductCategoryController::class);
});


Route::get('colors', [ColorController::class, "index"]);
Route::get('colors/{id}', [ColorController::class, "show"]);

Route::get('brands', [BrandController::class, "index"]);
Route::get('brands/{id}', [BrandController::class, "show"]);

Route::get('sizes', [SizeController::class, "index"]);
Route::get('sizes/{id}', [SizeController::class, "show"]);

Route::get('cuttings', [CuttingController::class, "index"]);
Route::get('cuttings/{id}', [CuttingController::class, "show"]);

Route::get('ocassions', [OcassionController::class, "index"]);
Route::get('ocassions/{id}', [OcassionController::class, "show"]);

Route::get('banner-categories', [BannerCategoryController::class, "index"]);
Route::get('banner-categories/{id}', [BannerCategoryController::class, "show"]);

Route::get('banners', [BannerController::class, "index"]);
Route::get('banners/{id}', [BannerController::class, "show"]);

Route::get('configs', [ConfigController::class, "index"]);
Route::get('configs/{id}', [ConfigController::class, "show"]);

Route::get('banks', [BankController::class, "index"]);
Route::get('banks/{id}', [BankController::class, "show"]);

Route::get('faqs', [FaqController::class, "index"]);
Route::get('faqs/{id}', [FaqController::class, "show"]);

Route::get('product-categories', [ProductCategoryController::class, "index"]);
Route::get('product-categories/{id}', [ProductCategoryController::class, "show"]);