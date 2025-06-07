<?php

namespace App\Http\Controllers\front;

use Throwable;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddressForm;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Intl\Countries;
use App\Repositories\CartRepository\CartRepositoryInterface;
use Illuminate\Support\Facades\Session;

class CheckOutController extends Controller
{
    public function create(CartRepositoryInterface $cart)
    {
  
    $countries = Countries::getNames(); 
    
    if(count($cart->get()) == 0){
        
        return redirect()->route('front.home');
    }
        return view('front.checkout', compact('cart' , 'countries'));
    }


    public function store(AddressForm $request, CartRepositoryInterface $cart)
    {  

        DB::beginTransaction();


        try {
            $items = $cart->get()->groupBy('product.store_id');
            $items = $items->all();
            foreach ($items as $key => $cartItems) {

                $order = Order::create(

                    [
                        'user_id' => Auth::id(),
                        'store_id' => $key,
                        'payment_method' => 'COD',
                        
                    ]
                );


                //create orderItem.
                foreach ( $cartItems as $item) {

                    OrderItem::create([

                        'order_id' => $order->id,
                        'product_id' => $item->product_id, //here we take product_id form cart and cart has more than one item so we mak loop on it
                        'product_name'=>$item->product->name ,
                        'product_price' => $item->product->price,
                        'quantity' => $item->quantity,
                        'options' => $item->options
                    ]);
                }

               
                 //catch data
            $address_data=$request->post('addr');
           
            foreach ($address_data as $key => $address) {

                //1-we need to get key from array of array .
                     $address['address_type']=$key;
                // need to add key to the address_data array .
                // 3- we don't need order_id becouse we take it from address relation .
                   $order->address()->create($address);
                
                    }
              
            }
            DB::commit(); //commit the three create operations .
            event('order.create' , $order , Auth::user());
            // dd( Session::get('failed-message'));
        
            return redirect()->route('front.home',[

               'success-message'=> Session::get('success-message') ,
               'failed-message'=> Session::get('failed-message')
            ]);
        } catch (Throwable $e) {

            DB::rollBack(); //rolling back from the created 
            throw $e;
        }
    }
}
