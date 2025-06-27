<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class MarkReadNotification
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        // we need to check if there ware paramiter called $notification_id send in request .

        $notification_id=$request->query('notification_id');

        if($notification_id){
            $user=$request->user();
            if($user){
                // $notification=$user->notifications()->find($notification_id);
                $notification=$user->notifications()->where('id',$notification_id)->first();

                if($notification){
                    $notification->markAsRead();
                }
            }
        }
        return $next($request);
    }
}
