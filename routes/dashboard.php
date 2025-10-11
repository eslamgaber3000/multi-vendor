<?php 

use App\Http\Middleware\IsAdmin;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\dashboard\UserController;
use App\Http\Controllers\dashboard\AdminController;
use App\Http\Controllers\dashboard\RolesController;
use App\Http\Controllers\dashboard\productController;
use App\Http\Controllers\Dashboard\ProfileController;
use App\Http\Controllers\dashboard\CategoryController;


Route::group(
    
    [
            'middleware'=>['auth:admin,web',
        'verified'    
        ],
            'as'=>'dashboard.',
            'prefix'=>'/admin',
                

                ],function(){


    //make routes for apply feature of softDelete should be before category of Resource route type
    
    Route::get('/category/trash',[CategoryController::class ,'trash'])->name('category.trash'); 
    //we use put or patch because we update we need to tell serve update the coloum of deleted_at to be null
    Route::put('/category/{category}/restore',[CategoryController::class ,'restore'])->name('category.restore'); 
    Route::delete('/category/{category}/force-delete',[CategoryController::class,'forceDelete'])->name('category.force-delete');
    Route::resource('dashboard/category',CategoryController::class);
    Route::resource('/dashboard/product',productController::class);
    Route::get('/dashboard', [DashboardController::class,'index'])->name('dashboard');

    //routes for soft delete product
    Route::get('/product/trash',[productController::class ,'trash'])->name('product.trash'); 
    Route::put('/product/{product}/restore',[productController::class ,'restore'])->name('product.restore'); 
    Route::delete('/product/{product}/force-delete',[productController::class ,'forceDelete'])->name('product.force-delete'); 

    //route for User profile 
    Route::get('profile',[ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('profile',[ProfileController::class, 'update'])->name('profile.update');


    //route for roles 
    Route::resource('dashboard/role',RolesController::class);

    // create routs for admins and users management
    Route::resources([
        'dashboard/admins'=>AdminController::class,
        'dashboard/users'=>UserController::class,
    ]);
    
});
