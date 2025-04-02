<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LastActiveTime
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */

    //  all this middleware do to store the last active data to any loged in user

    // to make this middleware global we need to store this middleware in kernal 
    public function handle(Request $request, Closure $next): Response
    {
        $user=$request->user();

        if($user){
            $user->last_active_at=now();
            $user->save();
        }
        return $next($request);
    }
}
