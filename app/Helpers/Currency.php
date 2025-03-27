<?php 

namespace  App\Helpers ;

use NumberFormatter;

Class Currency {
 
    // I need to make method to let me deal with currency class in php

    public static function formate($amount , $currency_code='USD'){

       $instance= new NumberFormatter(config('app.locale'),NumberFormatter::CURRENCY);
          return  $instance->formatCurrency($amount ,$currency_code);
    } 

}


?>