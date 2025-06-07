<?php

namespace App\Listeners;

use App\Facades\Cart;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CartEmpty
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
    public function handle($event): void
    {
        // if use the simple event don't use event object
        // we need to clear cart here.
        Cart::clear();

    }
}
