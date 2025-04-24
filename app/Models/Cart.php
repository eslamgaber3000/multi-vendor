<?php

namespace App\Models;

use Illuminate\Support\Str ;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cart extends Model
{
    use HasFactory;

    protected $fillable =['cookie_id' ,'user_id' ,'product_id' ,'quantity' ,'options'];

    public $incrementing = false ;

    protected $keyType='string';


    public static function booted(){


        static::creating(function( Cart $cart){

            $cart->id=Str::uuid();
        });

        static::addGlobalScope('cookie_id' ,function(Builder $builder){

            $builder->where('cookie_id','=',Cart::getCookieId());
        });

    }

    //En.Safady follows that cart one to one relationship cart and product

    public function product(){
        return $this->belongsTo(Product::class,'product_id','id');
    }

    //user has one cart
    public function user(){
        return $this->belongsTo(User::class ,'user_id','id')->withDefault( //with default you need to tell if no user make the name of user 'anonymous' and  don't tell 
                                                                            //error access brobery on null
           [ 'name'=>'anonymous']
        );
    }



//       make function to get cookie id
//  why this function doesn't in interface bedouse this function is associated with how to deal with cart using cookie spasific  not how to implement the cart in general
    public  static function getCookieId(){

        $cookie_id=Cookie::get('cart_id');

        if( ! $cookie_id){
            //create $cookie_id
            $cookie_id=Str::uuid();
            //store the value of cookie in cookies queue
            Cookie::queue('cart_id',$cookie_id, 60*24*30);
        }
        
        return $cookie_id;
    }
}
