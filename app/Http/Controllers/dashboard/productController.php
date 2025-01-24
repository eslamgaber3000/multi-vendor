<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class productController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $user=Auth::user();
        // if($user->store_id){

        //     $products=Product::where('store_id','=',$user->store_id)->paginate();
        // }else{
            
        // }

        //use eager loading instead of lazy loading to inhance the data retrifal
        $products=Product::with(['category','store'])->paginate();
        // dd($user_id);

        // dd($products);
        return view('dashboard.products.index',compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user=Auth::user();

        if($user->store_id){

            $product=Product::where('store_id','=',$user->store_id)->findOrFail($id);
        }else{
            $product=Product::findOrFail($id);

        }   
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
