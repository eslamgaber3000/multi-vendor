<?php 

use App\Http\Controllers\dashboard\CategoryController;
use App\Http\Controllers\dashboard\productController;
use App\Http\Controllers\Dashboard\ProfileController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;


Route::group(
    
    [
            'middleware'=>'auth',
            'as'=>'dashboard.',
            

                ],function(){


    //make routes for apply feature of softDelete should be before category of Resource route type
    
    Route::get('/category/trash',[CategoryController::class ,'trash'])->name('category.trash'); 
    //we use put or patch because we update we need to tell serve update the coloum of deleted_at to be null
    Route::put('/category/{category}/restore',[CategoryController::class ,'restore'])->name('category.restore'); 
    Route::delete('/category/{category}/force-delete',[CategoryController::class,'forceDelete'])->name('category.force-delete');
    Route::resource('dashboard/category',CategoryController::class);
    Route::resource('/dashboard/product',productController::class);
    Route::get('/dashboard', [DashboardController::class,'index'])->name('dashboard');
    //route for User profile 
    Route::get('profile',[ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('profile',[ProfileController::class, 'update'])->name('profile.update');
    
});
