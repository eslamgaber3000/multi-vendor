<?php

namespace App\Listeners;

use App\Models\User;
use App\Events\orderCreat;
use App\Notifications\OrderCreatedNotification;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderCteatedNotificatoin
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(orderCreat $event): void
    {
       //we need to send notification to store on 
       $order=$event->order;
       $store_id=$order->store_id;
        //if we want to send notification to more than one user(store_owner)
       $users=User::where('store_id',$store_id)->get();
       foreach($users as $user ){

           $user->notify(new OrderCreatedNotification($order));
       }
       
       //single user
       //   $user=User::where('store_id',$store_id)->first();
        //    $user->notify(new OrderCreatedNotification($order));
       
    }
}
