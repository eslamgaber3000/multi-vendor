<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TowFactorAuthenticationController extends Controller
{
    public function index (){

    $user = Auth::user();

    if($user){
    return view('front.auth.two-factor-authentication-setting' , compact('user'));

    }

    return redirect()->route('login');
    
    }
}
