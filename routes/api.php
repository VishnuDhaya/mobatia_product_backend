<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ApiLoginController;
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

Route::post('admin/login',[ApiLoginController::class, 'login']);

Route::middleware('auth:sanctum')->group(function(){

    Route::post('admin/logout',[ApiLoginController::class, 'logout']);

    Route::post('product/add',[ProductController::class, 'add']);
    Route::post('product/edit',[ProductController::class, 'edit']);
    Route::get('product/list',[ProductController::class, 'list']);
    Route::delete('product/delete/{id}', [ProductController::class, 'delete']);

});

