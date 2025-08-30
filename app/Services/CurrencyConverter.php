<?php
namespace App\Services ;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Config;


class CurrencyConverter 
{


    private $app_id ;

    public function __construct($app_id) {
        $this->app_id = $app_id;
    }

    public function convert( $base , $symbol , $amount = 1){

        $response= Http::withQueryParameters(['app_id'=>$this->app_id
        ,'base'=>$base,'symbol'=>$symbol,
        ])
        ->get('https://openexchangerates.org/api/latest.json');

            if ($response->failed()) {

                return ['error'=>'Unable to access data'];
                
                }

         $response ->json();  

         $rate =$response['rates'][$symbol];

         return $rate * $amount ;
        //  Session()->put('rate',['value'=>$rate,'code'=>$symbol]);
        //  Session()->put('code',$rate);

    }

}

