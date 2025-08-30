<?php

namespace App\Providers;

use App\Models\Product;
use App\Observers\ProductObserver;
use App\Services\CurrencyConverter;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind('currency_converter',function (){

            return new CurrencyConverter(config('services.currencyConverterKey')) ;
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //create new filter rule filter
        Validator::extend('filter',function($attribute,$value,$params){

            if(in_array(strtolower($value),$params)){
                return false;
            }else{
                return true;
            }

        },'this name can not be use it choose other name') ;


       Paginator::useBootstrap();
       //Paginator::defaultView('pagination.customPagination');


       //register our product observer .

       Product::observe(ProductObserver::class);
    }
    

    
}
