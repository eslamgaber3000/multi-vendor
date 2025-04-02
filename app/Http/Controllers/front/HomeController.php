<?php

namespace App\Http\Controllers\front;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cookie;
class HomeController extends Controller
{
    public function index(){

        // here we need to  show present products in our front

        $products=Product::active()->with(['category'])->latest()->limit(8)->get();
        // dd($products);
        return view('front.home' , compact('products'));
    }
}
