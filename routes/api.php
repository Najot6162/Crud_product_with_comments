<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\ProductApiController;

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

Route::post('/product',[ProductApiController::class,'store']);
Route::get('/products/{id}',[ProductApiController::class,'show']);
Route::get('/products',[ProductApiController::class,'index']);
Route::put('/products/{id}',[ProductApiController::class,'update']);
Route::delete('/products/{id}',[ProductApiController::class,'destroy']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
