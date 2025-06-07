<?php

namespace App\Models;

use App\Models\Scopes\StoreScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder ;
use Illuminate\Support\Facades\Auth ;
use Illuminate\Support\Str ;


class Product extends Model
{
    use HasFactory;
    protected $fillable=[

        'name','slug','description','image','store_id','category_id','rating','options','featured','price','compare_price','quantity','status'
    ];

    //Create relationship between category and Product
    public function category(){

        return $this->belongsTo(Category::class,'category_id','id');
    }
    //Create  one to many relationship between store and Product
    public function store(){

        return $this->belongsTo(Store::class,'store_id','id');
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

    //intialize active scope for products

    public function scopeActive ($query){
        $query->where('status' , '=' ,'active');
    }
    // use laravel accessors to check image after it came from db if it url or pathe or not found ; 
    public function getImageUrlAttribute (){

        if(! $this->image){

            return 'https://www.incathlab.com/images/products/default_product.png';
        }
        if(Str::startsWith( $this->image , ['http://','https://'])){
            return $this->image ;
        }

        return  asset('storage/'.$this->image);

        
    }

    //we need to make accessor to calculate the percentage of sale in each product

    public function getSalePercentageAttribute(){

        if(!$this->compare_price){
            return 0 ;
        }
        // sale percentage= 100*(sale_price / original price -1)
        return  number_format( 100* (($this->price / $this->compare_price)-1) ,0);
    }
}
