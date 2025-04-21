<?php
namespace App\Repositories\CartRepository;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str ;

class CartModelRepository implements CartRepositoryInterface
{
    public function get(): Collection
    {
        return Cart::where('cookie_id','=',$this->getCookieId())->get();

            
       
    }

    public function add(Product $product ,$quantity=1){

        $item = Cart::where('product_id',$product->id)
              ->where('cookie_id','=',$this->getCookieId())
              ->first();
                 // we should check before we create cart item if it exist update the quantity else  add product to cart
              if(!$item){

               return   Cart::create(
                      [
                          'cookie_id'=>$this->getCookieId(), //every time we need to add item in the same user cookie
                          'user_id'=>Auth::id(),
                          'product_id'=>$product->id,
                          'quantity'=>$quantity
                      ]
                      );

              }

            //   $old_quantity=$item->quantity;

            //   return   $item->update([

            //     'quantity'=>$quantity + $old_quantity 
            //   ]);
            return $item->increment('quantity' , $quantity); 

    }

    public function update(Product $product, $quantity)
    {
        Cart::where('product_id','=',$product->id)
        ->where('cookie_id','=',$this->getCookieId())
        ->update([
            'quantity'=>$quantity
        ]);
    }

    public function delete($id)
    {
        Cart::where('id','=',$id)
        ->where('cookie_id','=',$this->getCookieId())
        ->delete();
    }

    public function clear()
    {
        Cart::where('cookie_id','=',$this->getCookieId())->destroy();
    }
    public function total(): float
    {
        //sum the total  price of all product
     return  (float) Cart::where('cookie_id','=',$this->getCookieId()) 
                ->join('products','products.id','=','carts.product_id')
                ->selectRaw('SUM(products.price * carts.quantity) as total')
                ->value('total'); // we only need the total price (value) so use this function
                
    }

    //make function to get cookie id
 // why this function doesn't in interface bedouse this function is associated with how to deal with cart using cookie spasific  not how to implement the cart in general
    protected function getCookieId(){

        $cookie_id=Cookie::get('cart_id');

        if( ! $cookie_id){
            //create $cookie_id
            $cookie_id=Str::uuid();
            //store the value of cookie in cookies queue
            Cookie::queue('cart_id',$cookie_id, 60*24*30);
        }
        
        return $cookie_id;
    }

}

?>