<?php

use App\Http\Controllers\ChartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OutletController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductOrderController;
use Illuminate\Http\Request;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/chart/summary', [ChartController::class, 'summary'])->name('chart.summary');
Route::get('/chart/outlet/{id}', [ChartController::class, 'outlet'])->name('chart.outlet');
Route::get('/chart/product-summary', [ChartController::class, 'productSummary'])->name('chart.product-summary');
Route::get('/chart/product-outlet/{id}', [ChartController::class, 'productOutlet'])->name('chart.product-outlet');

Route::get('/outlets/{outlet}', [OutletController::class, 'get'])->name('outlets.get');
Route::get('/products/{product}', [ProductController::class, 'get'])->name('products.get');
Route::get('/orders/{order}', [OrderController::class, 'get'])->name('orders.get');
Route::get('/product-orders/{product_order}', [ProductOrderController::class, 'get'])->name('product-orders.get');
