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

    public $item ;

    public function get(): Collection
    {
        $this->item=collect([]);


        if($this->item->count() == 0 ){

           $this->item = Cart::with('product')->get();
        }
        return $this->item ;
       
    }

    public function add(Product $product ,$quantity=1){

        $item = Cart::where('product_id',$product->id)
              ->first();
                
              if(!$item){ // we should check before we create cart item if it exist update the quantity else  add product to cart

               return   Cart::create(
                      [
                          'cookie_id'=>Cart::getCookieId(), //every time we need to add item in the same user cookie
                          'user_id'=>Auth::id(),
                          'product_id'=>$product->id,
                          'quantity'=>$quantity
                      ]
                      );              }

            //   $old_quantity=$item->quantity;

            //   return   $item->update([

            //     'quantity'=>$quantity + $old_quantity 
            //   ]);
            return $item->increment('quantity' , $quantity); 

    }

    public function update($id, $quantity)
    {
        Cart::where('id','=',$id)
        ->update([
            'quantity'=>$quantity
        ]);
    }

    public function delete($id)
    {
        Cart::where('id','=',$id)
        ->delete();
    }

    public function clear()
    {
        Cart::query()->delete(); //this will make the cart empty .
    }
    public function total(): float
    {
        //sum the total  price of all product
    //  return  (float) Cart::join('products','products.id','=','carts.product_id')
    //                     ->selectRaw('SUM(products.price * carts.quantity) as total')
    //                     ->value('total'); // we only need the total price (value) so use this function
               
     return    $this->get()->sum(

            function($item){
                return  $item->quantity * $item->product->price ;
            }
        );        
    }

   
}

?>