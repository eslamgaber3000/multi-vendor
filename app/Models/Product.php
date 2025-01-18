<?php

namespace App\Models;

use App\Models\Scopes\StoreScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder ;
use Illuminate\Support\Facades\Auth ;


class Product extends Model
{
    use HasFactory;
    protected $fillable=[

        'name','slug','description','image','store_id','category_id','rating','options','featured','price','compare_price','status'
    ];


    protected static function booted(){
    
        //use closue to applay global scope
        // static::addGlobalScope('store', function (Builder $builder) {
            
        //     $user=Auth::user();
        
        //     if($user->store_id){
    
        //         $builder->where('store_id','=',$user->store_id);
        //     }
        // });

        //use class to applay  global scope
        static::addGlobalScope('store', new StoreScope()); 
    }
}
