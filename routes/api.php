<?php

use App\Http\Controllers\CreateNewParcelController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\ProductScanController;
use App\Http\Controllers\ProductSetParcelController;
use App\Http\Controllers\ShipParcelController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('orders', OrdersController::class);
Route::get('order/{order}', OrderController::class);
Route::patch('product/{product}/parcel/{parcel}', ProductSetParcelController::class);
Route::patch('product/{product}/scan', ProductScanController::class);
Route::patch('parcel/{parcel}/tracking', ShipParcelController::class);
Route::post('order/{order}/newparcel', CreateNewParcelController::class);
