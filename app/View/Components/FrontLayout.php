<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FrontLayout extends Component
{

    public $title ;
    /**
     * Create a new component instance.
     */
    public function __construct( $title=Null)
    {

        $this->title=$title ?? config('app.name');
        // $this->title=$title ? $this->title=$title : config('app.name');

        //make title attribute and it will be dynamic from every page user will visit
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('layouts.Front');
    }
}
