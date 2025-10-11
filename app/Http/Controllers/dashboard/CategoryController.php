<?php

namespace App\Http\Controllers\dashboard;

use Exception;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\CategoryRequest;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(Gate::denies('categories.view')){
            abort(403);
        }

        //probem : we need to show the name of parent category instead of the number of parent_id (parent_name insted of parent_id).    

        // selet categories.*, parents.name as parent_name
        // from categories LEFT JOIN Categories as Parents 
        // ON parents.id = categories.parent_id


        //using model query builder for filtering
        // $query = Category::query();
        // if ($name = request()->query('name')) {

        //     $query->where('name', 'like', "%{$name}%");
        // }


        // if ($status = request()->query('status')) {

        //     $query->where('status', '=', "$status");
        // }
        // $categories = $query->paginate(1);

        // $categories = Category::status('archived')->paginate();

        //use localscope for appling filter for ceeping controller clean
        //we can use with() and giv it the name of relatin to get parent_id with(parent)
        $categories = Category::leftJoin('categories as parents', 'categories.parent_id', '=', 'parents.id')
            ->select(['categories.*', 'parents.name as parent_name'])
            
            // ->select("categories.*")                                 //should be writen if I need to use selectRow() or addSelect() 
            //  ->addSelect(DB::row())                                  // return number of products in each category 
            //->selectRaw('(select count(*) from products where category_id=categories.id AND `status`='active' )as products_count')
            ->withCount(["products as products_number"=>
                function($query){
                    $query->where('status','=','active');
                }
            ]) 
            ->filter(request()->query())
            ->orderBy('categories.created_at', 'desc')
            ->paginate();
        return view('dashboard.categories.index', compact('categories'));
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if(!Gate::allows('categories.create')){
            abort(403);
        }
        $parents = Category::all();


        // dd($categories);
        $category = new Category();
      
        return view('dashboard.categories.create', compact('parents', 'category'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request){

        Gate::authorize('categories.create');

    
        $slug = $request->merge([

            'slug' => Str::slug($request->post('name'))
        ]);



        $data = $request->all();
        // $request->validate(Category::rules());

        //image upload  steps
        //1-make enc-type   2- check if user add image or not 3- move image form temp place to my pc
        // 4- store image name in database

        $data['image'] = $this->uploadImage($request);


        Category::create($data);
        return redirect()->route('dashboard.category.index')->with('success', 'Created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        if(Gate::denies('categories.view')){
            abort(403);
        }
        return view('dashboard.categories.show',[

            'category'=>$category
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        Gate::authorize('categories.edit');

        try {

            $category = Category::findOrFail($id);
        } catch (Exception $e) {

            return redirect()->route('dashboard.category.index')->with('info', 'record not found');
        }



        //select * from categories where  id <> $id And  (parent_id IsNull or parent_id <> $id)  


        $parents = Category::where('id', '<>', $id)
            ->where(function ($query) use ($id) {


                $query->whereNull('parent_id')
                    ->orwhere('parent_id', '<>', $id);
            })
            ->get();

        //->where('id','<>',$id)  dd();



        return view('dashboard.categories.edit', compact('category', 'parents'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if (!Gate::allows('categories.edit')) {
            abort(403);
        }

        $category = Category::findOrFail($id);
        $old_Image = $category->image;

        $data = $request->all();

        $request->validate(Category::rules($id));

        //check on the value of image field
        if ($this->uploadImage($request)) {


            $data['image'] = $this->uploadImage($request);
        }



        //update operation
        $category->update($data);

        //check if update old image delete old image and save the new one 
        if ($old_Image && isset($data['image']))

            //delete old image 
            Storage::disk('public')->delete($old_Image);

        //redirect method with flash message
        return redirect()->route('dashboard.category.index')->with('success', 'Updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {

        if(!Gate::allows('categories.delete')){
            abort(403);
        }
        // $category = Category::findOrFail($id);

        // $category=Category::where('id',$id)->delete();
        // $category=Category::destroy($id);
        $category->delete();
        //when use softDelete stop the code we do to delete the image from disk becouse we need to restore not permenently 
        // if ($category->image) {
        //     Storage::disk('public')->delete($category->image);
        // }


        return redirect()->route('dashboard.category.index')->with('success', 'deleted successfully');
    }


    //use this function to prevent redunduncy of code to use it in both create and update
    private function uploadImage(Request $request)
    {
        if (!$request->image) {
            return null;
        }
        $file = $request->file('image');
        $path = $file->store('uploads', [
            'disk' => 'public'
        ]);
        return $path;
    }

    public function trash(){

        //show deleted rows 

        $categories=Category::onlyTrashed()->paginate();
        //dd($categories);
        return view('dashboard.categories.trash',compact('categories'));
    }

    //trash restore need id 

    public function restore($id){

        //find category which is only and restore it
        
        $category=Category::onlyTrashed()->findOrFail($id);
        $category->restore();
        return redirect()->route('dashboard.category.trash')->with('success','restored successfully');
    }
    public function forceDelete($id){

        //find category which is only and restore it
        
        $category=Category::onlyTrashed()->findOrFail($id);
        $category->forceDelete();
        //when use softDelete stop the code we do to delete the image from disk becouse we need to restore not permenently 
        if ($category->image) {
            Storage::disk('public')->delete($category->image);
        }
        return redirect()->route('dashboard.category.trash')->with('success','restored successfully');
    }
}
