<?php
namespace App\Actions\Fortify ;

use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Config;


class AuthenticateUser {

public static function authenticate ($request) {

                    $username = $request->post(Config::get('fortify.username'));
                    //return the user if this username mach email , phone or username in Admin table  .
                    // $user = Admin::where('email', '=', $username)
                    //     ->orWhere('username', '=', $username)
                    //     ->orWhere('phone', '=', $username)
                    //     ->first();

                    //update my code to be more readable and editable
                    $user = Admin::where(function($query) use ($username){
                        $query->where('email' , '=' , $username)
                        ->orWhere('username', '=', $username)
                        ->orWhere('phone', '=', $username);
                        

                    })->first();
                        

                    //check if password mach user or not 

                    if ($user && $user->status=='active' && Hash::check($request->post('password'), $user->password)) {

                        return  $user;
                        // we need to return the user because we make our authentication using fortify package as documentation say .
                    }

                    // null or we can return false 

                }


}



?>