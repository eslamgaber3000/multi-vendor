<?php

namespace App\Listeners;

use App\Facades\Cart;
use Exception;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class QuantityDeduct
{


    /**
     * Create the event listener.
     */
    public function __construct()
    {
        
  
    }

    /**
     * Handle the event.
     */
    public function handle($order , $user=null): void
    {

        
       
        try {
            $items=Cart::get();
            $errors = [];
            foreach($items as $item){
            $product= $item->product ;
           
            if($item->quantity  <= $product->quantity  ){
                
                $product->update(
                    [
                        'quantity'=>DB::raw('quantity -' . $item->quantity)
                    ]
                );
               
                
            }else{

                    $errors [] = "Not enough quantity of {$item->product->name} , Please try again";
            }

          
        }

        if(count($errors)){

             Session::flash('failed-message' , implode('/n', $errors) );

        }else{
          Session::flash('success-message'," Your Order Done Successfully! ");  
        }


        } catch (\Throwable $th) {
            

             Session::flash('failed-message' ,'updated Failed  !'.$th->getMessage() );
        
        }
       

        
    }
}
