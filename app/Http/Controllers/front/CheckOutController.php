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


    public function store(Request $request, CartRepositoryInterface $cart)
    {
       

        // $request->validate([
        //     'user_id'=>['nullable' , 'exists:users,id' , 'alpha_num'],
        //     'store_id'=>['required' , 'exists:stores,id'],
        //     'payment_method'=>['required' , 'string'] ,
        //     'order_id'=>['required' , 'exists:orders,id'],
        //     'product_id'=>['required' , 'alpha_num' , 'exists:products,id'],
        //     'product_price'=>['required' , 'decimal:1,2'],
        //     'quantity'=>['required' , 'numeric'],
        //     'options'=>['nullable'] ,
        //     'address_type'=>['required' , 'in:pilling,shipping'],
        //     'status'=>['nullable',  'in:pending,processing,delivering,completed,canceled,refunding'] ,
        //     'first_name'=>['required' , 'string'],
        //     'last_name'=>['required' , 'string'],
        //     'email'=>[ 'required','email'],
        //     'mailing_address'=>['nullable','sting'],
        //     'phone_number'=>['required' ,'string'],
        //     'city'=>['required', 'string'],
        //     'postal_code'=>['nullable','string'],
        //     'country'=>['required','max:2' , 'min:2'],
        //     'state'=>['nullable', 'string']
        // ]);

        //create order

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
