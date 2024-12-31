<?php

namespace App\Http\Controllers\dashboard;

use Exception;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //user query builder in search()

        $categories=Category::paginate(3);
        // dd($categories);
         //collection class
        return view('dashboard.categories.index',compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $parents=Category::all();


        // dd($categories);
        $category=new Category();
        return view('dashboard.categories.create',compact('parents','category'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    
    {
        $slug=$request->merge([

            'slug'=>Str::slug($request->post('name'))
        ]);

        

        $data=$request->all();
        // $request->validate(Category::rules());
           
         //image upload  steps
        //1-make enc-type   2- check if user add image or not 3- move image form temp place to my pc
        // 4- store image name in database
       
        $data['image']=$this->uploadImage($request);

      
        Category::create($data);
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

        $category=Category::findOrFail($id);
        $old_Image=$category->image;

        $data= $request->all();

        $request->validate(Category::rules($id));
        
        //check on the value of image field
       if($this->uploadImage($request)){

           
           $data['image']=$this->uploadImage($request);
       }
        
      

        //update operation
        $category->update($data);

        //check if update old image delete old image and save the new one 
        if($old_Image && isset($data['image']))

        //delete old image 
        Storage::disk('public')->delete($old_Image);

        //redirect method with flash message
        return redirect()->route('dashboard.category.index')->with('success','Updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category=Category::findOrFail($id);
        
        // $category=Category::where('id',$id)->delete();
        // $category=Category::destroy($id);
        $category->delete();

        if($category->image){
            Storage::disk('public')->delete($category->image);
        }


        return redirect()->route('dashboard.category.index')->with('success','deleted successfully');
    }


    //use this function to prevent redunduncy of code to use it in both create and update
    private function uploadImage(Request $request){
        if(!$request->image){
             return null;
        }
            $file=$request->file('image');
            $path=$file->store('uploads',[
                'disk'=>'public'
            ]);
           return $path ;
        
    }
}
