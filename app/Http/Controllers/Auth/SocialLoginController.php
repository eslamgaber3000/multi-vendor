<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Laravel\Socialite\Socialite;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Throwable;

class SocialLoginController extends Controller
{
    public function redirect ($provider){

        return Socialite::driver($provider)->redirect();
    }

public function callback ($provider){
try {

    $social_provider_user = Socialite::driver($provider)->user();
    // we will follow this way if user login from the same provider make him login not register
    // otherwise we will register the user

    $user = User::where([
        'provider_id' => $social_provider_user->getId(),
        'provider' => $provider
    ])->first();
       
    if(!$user){
        // register user
        // $provider_token =  Crypt::encrypt($social_provider_user->token);
        $user = User::create([
            'name' => $social_provider_user->getName(),
            'email' => $social_provider_user->getEmail(),
            'password'=>Hash::make(Str::random(8)),
            'image'=>$social_provider_user->getAvatar(),
            'provider' => $provider,
            'provider_id' => $social_provider_user->getId(),
            // 'provider_token' => $provider_token,
            'provider_token' => $social_provider_user->token,
        ]);
    }
        // login the user
    Auth()->login($user);
    // redirect to home page
    return redirect()->route('front.home') ;

}  catch(Throwable $ex){
        return redirect()->route('login')->with(['error'=>"login failed pleas try again later".$ex->getMessage()]);
    }
      

    }
}
