<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpFoundation\Response;

class SetLocal
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        // $locale =$request ->input('language',session('language',config('app.locale')));
        // session()->put('language',$locale);
        // $locale =$request->route('locale'); // or 
        $locale =request()->route()->parameter('locale');
        app()->setLocale($locale);
        
        // $locale =$request->input('language');
        // if (request()->has('language')){
        //     App::setlocale($request->input('language'));
        //     session()->put('language',$request->input('language'));
        // }else {
        //     App::setlocale(session()->get('language',config('app.locale')));
        // }

        // gev default value form local parameter
        URL::defaults(['locale' => $locale]);
        
        // forget the route parameter locale
        $request->route()->forgetParameter('locale');

        return $next($request);
    }
}
