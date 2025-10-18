<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\RoleAblity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    // we use this constructor to apply policy to all resource methods
    public function __construct()
    {
        $this->authorizeResource(Role::class, 'role');
    }

    public function index()
    {
        
              // display all roles
        $roles = Role::paginate();
        return view('dashboard.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Gate::authorize('roles.create');
        $role = new Role();
        return view('dashboard.roles.create', compact('role'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Gate::authorize('roles.create');
        // dd($request->all());
        $request->validate((
            [
                'name'=>'required|string|max:255',
                'abilities'=>'required|array',
            ]
        ));


        // dd($request->post('abilities')['users.create']);
        DB::beginTransaction();
        try {
          $role= Role::create(
            [
                'name'=>$request->post('name')
            ]
        );

       
       foreach ($request->post('abilities') as $ability_key => $ability_value){ 
      
           RoleAblity::create([
               'role_id'=>$role->id,
                'ability'=>$ability_key,
               'type'=>$ability_value
           ]);
       }

         DB::commit();

        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
            //throw $th;
        }
      return redirect()->route('dashboard.role.create')->with('success','Role Created !');

    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        // Gate::authorize('roles.view');
        return view('dashboard.roles.show', compact('role'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        // Gate::authorize('roles.update');
    
        return view('dashboard.roles.edit', compact('role'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        // Gate::authorize('roles.update');

        $request->validate([
            'name'=>'required|string|max:255',
            'abilities'=>'required|array',
        ]);

       
        DB::beginTransaction();
        try {
            $role->update([
                'name'=>$request->post('name')
            ]);

            foreach ($request->post('abilities') as $ability_key=>$value){

                $role_ability=RoleAblity::where('role_id',$role->id)->where('ability',$ability_key)->first();

                if($role_ability){
                    $role_ability->update([
                        'type'=>$value
                    ]);
                }else{
                    RoleAblity::create([
                        'role_id'=>$role->id,
                        'ability'=>$ability_key,
                        'type'=>$value
                    ]);
                }
                // RoleAblity::updateOrCreate(
                //     [
                //         'role_id'=>$role->id,
                //         'ability'=>$ability,
                //     ],
                //     [
                //         'type'=>'allow'
                //     ]
                // );
            }
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
            //throw $th;
        }

        return redirect()->route('dashboard.role.index')->with('success','Role Updated !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role){
        // Gate::authorize('roles.delete');
        $role->delete();
        return redirect()->route('dashboard.role.index')->with('success','Role Deleted !');
    }
}
