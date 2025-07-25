<?php

namespace App\View\Components\admin;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

class Notifications extends Component
{
    
    public $notifications ;

    public $newCount ;
    /**
     * Create a new component instance.
     */
    public function __construct($count=10)
    {
        $user=Auth::user();
        $this->notifications=$user->notifications()->limit($count)->get();
        $this->newCount=$user->unreadNotifications()->count();

    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.admin.notifications');
    }
}
