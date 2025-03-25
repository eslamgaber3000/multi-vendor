<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    
    public function show(Product $product){
    // $product=Product::where('slug',$slug)->first();
    if(!$product){

        return abort(404);
    }
    return view('front.show',compact('product'));
    }

}
