<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
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

        $locale =$request->input('language');
        $locale =$request ->input('language',session('language',config('app.locale')));
        app()->setLocale($locale);
        session()->put('language',$locale);

        // if (request()->has('language')){
        //     App::setlocale($request->input('language'));
        //     session()->put('language',$request->input('language'));
        // }else {
        //     App::setlocale(session()->get('language',config('app.locale')));
        // }
        
        return $next($request);
    }
}
