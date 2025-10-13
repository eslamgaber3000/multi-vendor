<?php

namespace App\Http\Controllers\dashboard;

use App\Models\Role;
use App\Models\Admin;
use Auth;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       if (!Gate::allows('admins.view'))
       {
        return abort(403);
       }
        $admins = Admin::where('id' ,'<>',value: Auth::user()->id)->paginate();

        // dd(vars: $admins);
       
        return view('dashboard.admins.index' ,compact('admins'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!Gate::allows('admins.create')) {
            return abort(403);
        }
        $admin = new Admin();
        $roles= Role::all();
        return view('dashboard.admins.create', ['admin'=>$admin ,'roles'=>$roles]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        Gate::authorize('admins.create');
       
        $request->merge(
           [ 'username'=>Str::slug("Arrzak-".$request->post('name'))]
        );

         
        $request->validate([
            'name'=>'required|string|min:3|max:256',
            'email'=>'required|email|unique:admins,email,except,id',
            'username'=>'required|unique:admins,username,except,id',
            'phone'=>'required|string|size:13',
            'image'=>'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'password'=>'required|min:8' ,
            'status'=>'required|in:active,not_active',
            'super_admin'=>'nullable|in:1,0',
            'role'=>'required|exists:roles,id'


        ]);

        $image = $this->uploadImage($request);
       
       
        if(!$request->has('super-admin')){
            $request->merge(['super-admin'=>0]);
        }
     $role_id =$request->post('role');
     DB::beginTransaction();

     try {

         $admin= Admin::create(
         [   
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'username'=>$request->username,
            'phone'=>$request->phone ,
            'image'=>$image,
            'status'=>$request->status,
            'super_admin'=>$request->post('super-admin')
            ]
        );

       
        $role= Role::findOrFail($role_id);
        if($role->name){

            $admin->roles()->attach($role);
        }

        DB::commit();

     } catch (\Throwable $th) {
        DB::rollBack();
        throw $th;
     }
       
      
        return redirect()->back()->with("Admin Created successfully !");
       
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
        //
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


       private function uploadImage(Request $request)
    {
        if (!$request->image) {
            return null;
        }
        $file = $request->file('image');
        $path = $file->store('uploads/Admin', [
            'disk' => 'public'
        ]);
        return $path;
    }
}
