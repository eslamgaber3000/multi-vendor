<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Repositories\CartRepository\CartModelRepository;
use App\Repositories\CartRepository\CartRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public $cart ;

     public function __construct(CartRepositoryInterface $cart )
     {
        $this->cart=$cart ;
        
     }

    //  public function index(CartRepositoryInterface $cart) we was use this shape
    public function index() // this is feature in laravel throw my objects into the action
    {
        
        // $cart_model_repository=new cartModelRepository(); // using the repository class without service container;
       //$cart_model_repository= App::make('Cart');

        return view('front.cart.index',[
            'cart'=>$this->cart
        ]);
    }

   

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request )
    {
        // $cart_model_repository=new cartModelRepository(); // we don't need to every time store the  cart
        
        $request->validate([

            'product_id'=>'required','integer','exists:products,id',
            'quantity'=>'nullable','integer','min:1'

        ]);

        $product=Product::findOrFail($request->post('product_id'));
        $this->cart->add($product , $request->post('quantity'));
        return redirect()->route('Cart.index')->with('success' , 'Cart add to cart !');

        
    }

    

   

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CartRepositoryInterface $cart)
    {
        // $cart_model_repository=new cartModelRepository();
        
        $request->validate([

            'product_id'=>'required','integer','exists:products,id',
            'quantity'=>'nullable','integer','min:1'

        ]);

        $product=Product::findOrFail($request->post('product_id'));
        $cart->update($product,$request->post('quantity'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CartRepositoryInterface $cart ,  string $id)  //when we have paraemter in route and need thing from service container; first should sevice contaner
    {
        // $cart_model_repository=new cartModelRepository();

        $cart->delete($id);
    }
}
