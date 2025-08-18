<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class ProductController extends Controller
{

    //define middleware to create , update and delete actions
    public function __construct()
    {
        $this->middleware('auth:sanctum')->only(['create','update','destroy']);
        // or we can use
        // $this->middleware('auth:sanctum')->except(['index','show']);

    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {


    $products=Product::filter($request->query())
    ->with(['category:id,name','store:id,name','tags:id,name'])
    ->paginate(); 
//here we can try to use product resource ,

// return ProductResource::collection($products);
    return $products ;
    
    // ->when($request->query('tag_id'), function($query , $value){

    //     $query->whereHas('tags',function($query) use ($value){  //but will consume much time in database 
    //         $query->where('id','=',$value);
    //     });
    // })

//    ->when($request->query('tag_id'), function($query , $value){


    //   $query->whereHas('tags', function($query) use($value){   1-//consume high in database .
    //         $query->where('id',$value);
    //     });
    // $query->whereExists(function($query) use ($value){
    //     $query->selectRaw('1')->from('product_tag')->whereColumn('products.id', 'product_tag.product_id')
    //     ->where('product_tag.tag_id',$value); // 2-best practice because we use exits and use laravel query builder to make it more readable.
    // });
    // $query->whereRaw('Exists (SELECT 1 FROM product_tag where product_tag.product_id=products.id AND product_tag.tag_id = ?)',[$value]); //3-exactly number 2 but it is raw sql

           // $query->whereRaw('id IN (SELECT product_id from product_tag where tag_id = ?)',[$value] ); //using prepared statement //4-using IN clause but when we don't using in in large database.
        // });
//    })






    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       $request->validate([

        'name'=>'required|string|min:3|max:30',
        'description'=>'nullable|string',
        'status'=>'nullable|in:active,draft,archived',
        'price'=>'required|integer|min:200',
        'compare_price'=>'nullable|integer|gt:price',
        'category_id'=>'required|exists:categories,id'
       ]);


       $product=Product::create($request->all());

    //    in restful api we should return the item we add .

        // return $product ;

        // if you don't use this store action you should tell laravel to return json
       return Response::json(['product'=>$product,'message=>product add successfully'],201);

    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product) //can I use model binding
    {

        // we can use the resource to show the product 

        // return new ProductResource($product) ;
        return response()->json($product->load('category:id,name', 'store:id,name','tags:id,name'));
        //  $product=Product::with(['category:id,name','store:id,name','tags:id,name'])->findOrFail($id);

        // return $product ;

    
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $product=Product::findOrFail($id);

         //validate data 
        $request->validate([
        'name'=>'sometimes|required|string|min:3|max:30',
        'description'=>'nullable|string',
        'status'=>'nullable|in:active,draft,archived',
        'price'=>'sometimes|required|integer|min:200',
        'compare_price'=>'nullable|integer|gt:price',
        'category_id'=>'sometimes|required|exists:categories,id'

        ]);
    
       
        $product->update($request->only(['name', 'description','status','price','compare_price','category_id']));
        
        return $product;

        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        Product::destroy($id);
        //  $product=Product::findOrFail($id);
     return response()->json(['message'=>'product Deleted successfully']);
    }
}
