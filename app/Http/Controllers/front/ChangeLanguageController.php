<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class ChangeLanguageController extends Controller
{
    public function change(Request $request){

            $request->validate([
                
                'locale'=>'required|string|size:2'
            ]);        
        $locale= $request->input('locale');

return redirect(LaravelLocalization::getLocalizedURL($locale, url()->previous(), [], true));

    }
}
