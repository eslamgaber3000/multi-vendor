<?php 

namespace  App\Helpers ;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use NumberFormatter;

Class Currency {
 
    // I need to make method to let me deal with currency class in php

    public static function formate($amount , $base_currency){

      $base_currency = Session::get('currency_code' , "USD");
      $cache_key = 'currency_rate'.$base_currency ;
     

       if(Cache::has($cache_key)){

        $rate = Cache::get($cache_key);
        $amount = $amount * $rate ;
       }

   
       $instance= new NumberFormatter('en_US',NumberFormatter::CURRENCY);
       // here to set the currency code instead of symbol
       $instance->setTextAttribute(NumberFormatter::CURRENCY_CODE, $base_currency);
        $instance->setSymbol(\NumberFormatter::CURRENCY_SYMBOL, $base_currency);

          return  $instance->formatCurrency($amount , $base_currency);
    } 

}


?>