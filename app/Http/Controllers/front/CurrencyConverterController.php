<?php

namespace App\Http\Controllers\front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\CurrencyConverter;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session ;

class CurrencyConverterController extends Controller
{
    public function store(Request $request){
       
        //validate data
        $request->validate([
            'currency'=>'required|string|size:3'
        ]);

        $symbol = $request->post('currency');
        $cache_key = 'currency_rate'.$symbol ;
        Session::put('currency_code',$symbol);

        if (!Cache::has($cache_key)) {
            
            $currencyConverter = new CurrencyConverter(config('services.currencyConverterKey')) ;
            // $currencyConverter=App::make('currency_converter'); // we can use service container inseated making objected direct from CurrencyConverter Class .
            $base_currency = Config::get('app.currency');
            $rate = $currencyConverter->convert( $base_currency ,$symbol);
            // here I want to store the value of the rate in cache.
            Cache::put('currency_rate'.$symbol,$rate,now()->addHours());

        }


        //  Session()->put('rate',Cache::get($cache_key));
         return redirect()->back();

    }
}
