<?php 

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\dashboard\CategoryController;


Route::group(
    
    [
            'middleware'=>'auth',
            'as'=>'dashboard.',
            

                ],function(){



    Route::resource('dashboard/category',CategoryController::class);
    Route::get('/dashboard', [DashboardController::class,'index']);
    
    
});
