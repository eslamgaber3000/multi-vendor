<?php 

namespace  App\Helpers ;

use Illuminate\Support\Facades\Session;
use NumberFormatter;

Class Currency {
 
    // I need to make method to let me deal with currency class in php

    public static function formate($amount , $base_currency='USD'){

       if (Session::has('currency_code')) {
        $base_currency = Session::get('currency_code');
       } else {
        $base_currency = config('app.currency');
       }
      
       if(Session::has('rate')){

        $rate = Session::get('rate');
        $amount = $amount * $rate ;
       }
       $instance= new NumberFormatter(config('app.locale'),NumberFormatter::CURRENCY);
          return  $instance->formatCurrency($amount , $base_currency);
    } 

}


?>