<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class nav extends Component
{
    /**
     * Create a new component instance.
     */

    public $items;

    public function __construct()
    {
        $this->items = $this->showNavItems();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.nav');
    }

    public function showNavItems(){

        $items = config('nav');

        foreach($items as $item_key=>$item_value){

            if(isset($item_value['abilities']) && auth()->user()->cannot($item_value['abilities'])){

                unset($items[$item_key]);
            }
        }
        return $items;
    }
}
