<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OutletController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductOrderController;

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

Route::get('/', function () {
    return redirect()->route('home.index');
});

Route::resource('home', HomeController::class);
Route::resource('outlets', OutletController::class);
Route::resource('orders', OrderController::class);
Route::resource('products', ProductController::class);
Route::resource('product-orders', ProductOrderController::class);

Route::post('outlets/import', [OutletController::class, 'import'])->name('outlets.import');
Route::delete('outlets/wipe', [OutletController::class, 'wipe'])->name('outlets.wipe');
Route::post('orders/import', [OrderController::class, 'import'])->name('orders.import');
Route::delete('orders/wipe', [OrderController::class, 'wipe'])->name('orders.wipe');
Route::post('products/import', [ProductController::class, 'import'])->name('products.import');
Route::delete('products/wipe', [ProductController::class, 'wipe'])->name('products.wipe');
Route::post('product-orders/import', [ProductOrderController::class, 'import'])->name('product-orders.import');
Route::delete('product-orders/wipe', [ProductOrderController::class, 'wipe'])->name('product-orders.wipe');
