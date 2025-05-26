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
       

//catch and validate address data .

// $pill_firs_name=$request->input('addr.pilling.first_name');
// $pill_last_name=$request->input('addr.pilling.last_name');
// $pill_email_name=$request->input('addr.pilling.email');



// $request ->validate([

// 'addr.pilling.first_name' => 'required|string|max:30|min:3',
// 'addr.pilling.last_name' => 'required|string|max:30|min:3',
// 'addr.pilling.email' => 'required|email',
// 'addr.pilling.phone_number' => 'required|string',
// 'addr.pilling.mailing_address' => 'required|string|max:100|min:10',
// 'addr.pilling.postal_code' => 'nullable|string',
// 'addr.pilling.country' => 'required|string|min:2|max:3',
// 'addr.pilling.state' => 'nullable|string',
// 'addr.shipping.first_name' => 'required|string|max:30|min:3',
// 'addr.shipping.last_name' => 'required|string|max:30|min:3',
// 'addr.shipping.email' => 'required|email',
// 'addr.shipping.phone_number' => 'required|string',
// 'addr.shipping.mailing_address' => 'required|string|max:100|min:10',
// 'addr.shipping.postal_code' => 'nullable|string',
// 'addr.shipping.country' => 'required|string|min:2|max:3',
// 'addr.shipping.state' => 'nullable|string',

// ]);



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
              
                // OrderAddress::create([
                //     //catch data from from
                //     'order_id' => $order->id,
                //     'address_type' => $request->post('address_type'),
                //     'first_name' => $request->post('first_name'),
                //     'last_name' => $request->post('last_name'),
                //     'email' => $request->post('email'),
                //     'mailing_address' => $request->post('mailing_address'),
                //     'phone_number' => $request->post('phone_number'),
                //     'city' => $request->post('city'),
                //     'postal_code' => $request->post('postal_code'),
                //     'country' => $request->post('country'),
                //     'state' => $request->post('state')

                // ]);
            }
            DB::commit(); //commit the three create operations .
            //empty cart .
            $cart->clear();
            return redirect()->route('front.home');
        } catch (Throwable $e) {

            DB::rollBack(); //rolling back from the created 
            throw $e;
        }
    }
}
