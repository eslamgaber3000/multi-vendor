<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str ;

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
}
