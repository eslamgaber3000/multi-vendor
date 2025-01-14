<?php 

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\dashboard\CategoryController;


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
    Route::get('/dashboard', [DashboardController::class,'index'])->name('dashboard');
    
    
});
