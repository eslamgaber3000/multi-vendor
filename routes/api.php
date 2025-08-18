<?php

use App\Http\Controllers\Api\AuthenticateUserController;
use App\Http\Controllers\Api\ProductController;
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

Route::apiResource('product',ProductController::class);  // this what I need when I using api((excluding create , edit)
// Route::resource('product',ProductController::class)->except(['create','edit']);  // this what I need when I using api

// I want to make endpoint for authintication using laravel sanctum .

Route::post('login',[AuthenticateUserController::class,'login']);
Route::delete('logout/{token?}',[AuthenticateUserController::class,'destroy'])->middleware('auth:sanctum');
Route::delete('all-devices-logout',[AuthenticateUserController::class,'destroyAll'])->middleware('auth:sanctum');

