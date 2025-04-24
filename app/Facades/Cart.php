<?php
namespace App\Facades ;

use Illuminate\Support\Facades\Facade;
use App\Repositories\CartRepository\CartModelRepository;

Class Cart extends Facade
{

    protected static function getFacadeAccessor()
    {
        return CartModelRepository::class;
    }
}





?>