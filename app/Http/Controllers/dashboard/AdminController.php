<?php

namespace App\Http\Controllers\dashboard;

use Auth;
use App\Models\Role;
use App\Models\Admin;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
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
            'phone'=>'required|string|size:13|unique:admins,phone,except,id',
            'image'=>'image|mimes:jpeg,png,jpg,gif|max:2048',
            'password'=>'required|min:8' ,
            'status'=>'required|in:active,not_active',
            'super_admin'=>'nullable|in:1,0',
            'roles'=>'required|array|exists:roles,id'


        ]);

        $image = $this->uploadImage($request);
       
       
        if(!$request->has('super-admin')){
            $request->merge(['super-admin'=>0]);
        }
     $role_ids =$request->post('roles');
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

       foreach($role_ids as $role_id){
        $role= Role::findOrFail($role_id);
        if($role->name){

            $admin->roles()->attach($role);
        }
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
    public function edit(Admin $admin)
    {
        Gate::authorize('admins.edit');
        $roles= Role::all();
        $admin_roles_id= $admin->roles->pluck('id');
        return view('dashboard.admins.edit', ['admin'=>$admin ,'roles'=>$roles ,'admin_roles_id'=>$admin_roles_id]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Admin $admin)
    {

        $request->merge(
           [ 'username'=>Str::slug("Arrzak-".$request->post('name'))]
        );

         
        $request->validate([
            'name'=>'required|string|min:3|max:256',
            'email'=>['required','email',Rule::unique('admins')->ignore($admin->id)],
            'username'=>['required',Rule::unique('admins')->ignore($admin->id)],
            'phone'=>'required|string|size:13|'.Rule::unique('admins')->ignore($admin->id),
            'image'=>'image|mimes:jpeg,png,jpg,gif|max:2048',
            'password'=>'required|min:8' ,
            'status'=>'required|in:active,not_active',
            'super_admin'=>'nullable|in:1,0',
            'roles'=>'required|array|exists:roles,id'


        ]);

        $image = $this->uploadImage($request);
       
       
        if(!$request->has('super-admin')){
            $request->merge(['super-admin'=>0]);
        }
     $role_ids =$request->post('roles');
     DB::beginTransaction();

     try {

        $admin->update(
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
         

// sync to update the roles of admin
        $admin->roles()->sync($role_ids);
      
        DB::commit();

     } catch (\Throwable $th) {
        DB::rollBack();
        throw $th;
     }


        return redirect()->route('dashboard.admins.index')->with("Admin Updated successfully !");

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
