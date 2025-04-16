<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Repositories\cartRepository\cartModelRepository;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cart_model_repository=new cartModelRepository();

        $items=$cart_model_repository->get();

        return view('front.cart.index',[
            'cart'=>$items
        ]);
    }

   

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $cart_model_repository=new cartModelRepository();
        
        $request->validate([

            'product_id'=>'required','integer','exists:products,id',
            'quantity'=>'nullable','integer','min:1'

        ]);

        $product=Product::findOrFail($request->post('product_id'));
        $cart_model_repository->add($product , $request->post('quantity'));

        
    }

    

   

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $cart_model_repository=new cartModelRepository();
        
        $request->validate([

            'product_id'=>'required','integer','exists:products,id',
            'quantity'=>'nullable','integer','min:1'

        ]);

        $product=Product::findOrFail($request->post('product_id'));
        $cart_model_repository->update($product,$request->post('quantity'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $cart_model_repository=new cartModelRepository();

        $cart_model_repository->delete($id);
    }
}
