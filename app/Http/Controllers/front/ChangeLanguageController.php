<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session ;

class ChangeLanguageController extends Controller
{
    public function store(Request $request){

       $lang= $request->input('language');
       

        $request->validate([

            'language'=>'required|string|size:2'
        ]);        
        Session::put('language',$lang);
        

        return redirect()->back();

    }
}
