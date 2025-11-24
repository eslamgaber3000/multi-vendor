<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\front\CartController;
use App\Http\Controllers\front\HomeController;
use App\Http\Controllers\front\CheckOutController;
use App\Http\Controllers\front\ProductsController;
use App\Http\Controllers\front\ChangeLanguageController;
use App\Http\Controllers\front\CurrencyConverterController;
use App\Http\Controllers\TowFactorAuthenticationController;
use App\Jobs\DeleteOldPendingOreder;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

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


Route::group( [

    'prefix'=>LaravelLocalization::setLocale(),
    'middleware'=>[ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
],
function(){

Route::get('/' , [HomeController::class ,'index'])->name('front.home');
Route::get('products/index' ,[ProductsController::class,'index'])->name('front.products.index'); 
// products/show/{product:slug} => this mean use model binding and customize it with slug not id ;
Route::get('products/show/{product:slug}' ,[ProductsController::class,'show'])->name('front.products.show');  


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('Cart' ,CartController::class);
Route::get('/checkout', [CheckOutController::class, 'create'])->name('front.checkout');
Route::post('/checkout' ,[CheckOutController::class,'store']);
 
Route::get('tow-factor-authentication-setting',[TowFactorAuthenticationController::class, 'index'])->name('2fa.setting');

// route fro currency converter 
Route::post('convert-currency',[CurrencyConverterController::class,'store'])->name('convert-currency');
Route::post('change-language',[ChangeLanguageController::class,'change'])->name('change-language');
});
require __DIR__.'/dashboard.php';

Route::get('/clear-session', function () {
    Session::forget(['message', 'type']);
    return 'Session cleared ✅';
});


// lets try run the job to delete old pending orders

Route::get('/delete-old-pending-orders', function () {
    DeleteOldPendingOreder::dispatch();
    return 'DeleteOldPendingOreder job dispatched!';
});


