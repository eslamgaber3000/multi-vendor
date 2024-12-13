<?php

namespace App\Http\Controllers\dashboard;

use Exception;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $categories=Category::all();
         //collection class
        return view('dashboard.categories.index',compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories=Category::all();
        // dd($categories);
        return view('dashboard.categories.create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $slug=$request->merge([

            'slug'=>Str::slug($request->post('name'))
        ]);

        

        $category=$request->all();
        Category::create($category);
        return redirect()->route('dashboard.category.index')->with('success','Created successfully');
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
         
        try{

            $category=Category::findOrFail($id);

        }catch(Exception $e ){

            return redirect()->route('dashboard.category.index')->with('info','record not found');
        }

        
        
        //select * from categories where  id <> $id And  (parent_id IsNull or parent_id <> $id)  
    

        $parents=Category::where('id','<>',$id)
        ->where(function($query) use($id){


           $query->whereNull('parent_id')
            ->orwhere('parent_id','<>',$id);
        })
        ->get();
       
        //->where('id','<>',$id)  dd();

      

        return view('dashboard.categories.edit',compact('category','parents'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $Updated_category = $request->all();

        
        //validation

        //update operation
        $category=Category::findOrFail($id);
        $category->update($Updated_category);
        //redirect method with flash message
        return redirect()->route('dashboard.category.index')->with('success','Updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // $category=Category::where('id',$id)->delete();
        // $category->delete();

        $category=Category::destroy($id);

        return redirect()->route('dashboard.category.index')->with('success','deleted successfully');
    }
}
