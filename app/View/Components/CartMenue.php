<?php

namespace App\View\Components;

use App\Facades\Cart;
use App\Repositories\CartRepository\CartModelRepository;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CartMenue extends Component
{

    public $cart ;

    public $total ;
    /**
     * Create a new component instance.
     */
    public function __construct(CartModelRepository $cart )
    {
        // use service container ;
        
        // $this->cart=$cart->get();
        // $this->total=$cart->total();


        //use facade class 
       $this->cart=Cart::get();
       $this->total=Cart::total();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.cart-menue');
    }
}
