<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Socialite;

class SocialLoginController extends Controller
{
    public function redirect ($provider){

        return Socialite::driver($provider)->redirect();
    }

    public function callback ($provider){

        $userSocial = Socialite::driver($provider)->user();

        
    }
}
