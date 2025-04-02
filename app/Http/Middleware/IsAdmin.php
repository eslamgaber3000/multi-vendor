<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next ,...$types): Response
    {
        //create custom middleware to apply it in register dashboard route 
        $user=request()->user();

        if(!$user){
           return redirect()->route('login');
        }

        if( ! in_array($user->role , $types) ){
            abort(403);
        }
        return $next($request);
    }
}
