<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChartController;

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
