<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\front\HomeController;
use App\Http\Controllers\front\ProductsController;
use App\Http\Controllers\dashboard\productController;
use App\Http\Controllers\dashboard\CategoryController;

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

Route::get('/' , [HomeController::class ,'index'])->name('front.home');
Route::get('products/index' ,[productController::class,'index'])->name('front.products.index'); 
// products/show/{product:slug} => this mean use model binding and customize it with slug not id ;
Route::get('products/show/{product:slug}' ,[ProductsController::class,'show'])->name('front.products.show');  


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
require __DIR__.'/dashboard.php';
