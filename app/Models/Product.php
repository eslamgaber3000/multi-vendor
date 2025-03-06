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

    //Create relationship between category and Product
    public function category(){

        return $this->belongsTo(Category::class,'category_id','id');
    }
    //Create  one to many relationship between store and Product
    public function store(){

        return $this->belongsTo(Stores::class,'store_id','id');
    }


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

    //many to many relationship between porduct and his tags

    public function tags(){


        return $this->belongsToMany(

            Tag::class ,'product_tag','product_id' ,'tag_id','id','id'
            
        );
    }
}
