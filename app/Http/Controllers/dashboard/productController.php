<?php

namespace App\Http\Controllers\dashboard;

use App\Models\Tag;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str ;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class productController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // using policy for authorization

        if(Auth::user()->cannot('viewAny',Product::class)){
            return abort(403); 
        }
        // Gate::authorize('products.view');
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
    
     // using policy for authorization with user model

        if(request()->user()->cannot('create',Product::class)){
            return abort(403); 

        }

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // using policy for authorization via controller helper
        $this->authorize('create', Product::class);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product=Product::findOrFail($id);
        $this->authorize('view',$product);
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
       $product=Product::findOrFail($id);
        $this->authorize('update',$product);

        $user=Auth::user();

        if($user->store_id){

            $product=Product::where('store_id','=',$user->store_id)->findOrFail($id);
        }else{
            $product=Product::findOrFail($id);

        }
        $categories=Category::all();
        //catch tags from relationship

        //transform collection to array and the to string to show this in edit , and pluck to retrive all of the value for given key
        $tags=implode(',',$product->tags()->pluck('name')->toArray());
        return view('dashboard.products.edit',compact('categories','product','tags'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        Gate::authorize('products.update');
        $products_without_tags=$request->except('tags');

        $product->update($products_without_tags);

        $input_tags= json_decode($request->post('tags'));
        // $input_tags=explode(',',$request->post('tags'));
       
        $tag_ids=[];
        $saved_tags=Tag::all();  // this will return collection with all of tags

        if($input_tags){
         foreach($input_tags as $item){
            // dd($item->value);
            $slug=Str::slug($item->value);
            //search into tags table
            $tag=$saved_tags->where('slug' ,'=',$slug)->first();
        //check if tag exist or not 
            if (!$tag) {
            # create tags
              $tag=Tag::create([
                'name'=>$item->value,
                'slug'=>$slug
            ]);
          }

        //insert into pivot table using tags() relationship
         $tag_ids[]=$tag->id;
        }
        }
     
        $product->tags()->sync($tag_ids); //deal with relation to link tags belongs to product
       
        
        //catch data , validate data , update product , tags:: check if tags is found in tags table or not ? 
                                                        //if found ... I will take ids of tags , not found create tags into tags table 

        //there some thing should be noticed : what will be stored in table product_tags ?? tags_ids and product_id
        //make syncronization into product_tags table update and delete as required
        //redirect message
        return redirect()->route('dashboard.product.index')->with('success','Product Updated');
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $this->authorize('delete', $product);
        // we make soft delete to product
        $product->delete();

        return redirect()->route('dashboard.product.index')->with('success', 'deleted successfully');

    }
    public function trash(){

        $products = Product::onlyTrashed()->paginate();
        return view('dashboard.products.trash',compact('products'));
    }

    public function restore ( $id){

        $product = Product::onlyTrashed()->findOrFail($id);
      
        $product->restore();
        return redirect()->route('dashboard.product.trash')->with('success','restored successfully');
    }

    public function forceDelete($id){
        $product = Product::onlyTrashed()->findOrFail($id);
        $product->forceDelete();
        return redirect()->back()->with('success','product deleted permenently');
    }
}
