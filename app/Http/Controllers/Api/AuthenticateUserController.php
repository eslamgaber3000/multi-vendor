<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Laravel\Sanctum\PersonalAccessToken;

class AuthenticateUserController extends Controller
{
    public function login(Request $request){

        $request->validate([

            'email'=>'required|email',
            'password'=>'required|min:8',
            'device-name'=>'nullable|string'
        ]);

        $user=User::where('email','=',$request->post('email'))->first();
        if (!$user || ! Hash::check($request->post('password'),$user->password)) {

                return Response::json([ 'code'=>0,'message'=>'invalid credentials'], 401);

            }
            $token=$user->createToken($request->post('device-name',$request->header('User-Agent')))->plainTextToken;
                return Response::json([
                    'code'=> 1 ,
                    'token'=>$token ,
                    'user'=>$user
                ], 201);
    }


    public function destroy($token = null)
    {

        $user = Auth::user();
        // delete spesfic toke

        if ($token === null) {

            $user->currentAccessToken()->delete();

            return Response::json(['message' => 'current user  is logged out']);
        }
        $personalAccessToken = PersonalAccessToken::findToken($token); //here I get object from token 

        if ($personalAccessToken) {
            // check if this token to this auth user and same role
            if ($personalAccessToken->tokenable_id == $user->id  && $personalAccessToken->tokenable_type == get_class($user)) {
                $user->tokens()->where('id', '=', $personalAccessToken->id)->delete(); //the toke in database will be hashed I need it plain text
            }

            // logout form all devices 
            // $user->tokens()->delete();

            return Response::json(['message' => 'other use  is logged out']);
        }else {
            return Response::json(['message' => 'no user found']);
        }
    }
}
