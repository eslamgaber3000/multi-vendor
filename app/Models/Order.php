<?php

namespace App\Models;

use App\Models\Store;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;


    protected $fillable =[ 

        'user_id', 'store_id', 'status','payment_status','payment_method'
    ];

    public static function booted(){

        static::creating(function ( Order $order) {
    

            
            //this will be the first order at all , or the first order in this year .
            // we can make some thing like getNextNumber
            //formate of order_number year concatenated with 4 number ex(20250001, 20250002) 

            // $order->order_number=$nextNumber;

            //using function to mange reusability
            $order->order_number=Order::getNextNumber(); 

        });
    }


    public function user(){
        //now because this column is nullable we need to pass default  value in this relationship .
        return $this->belongsTo(User::class)
        ->withDefault(
            ['name'=>'Gust User']
        )
        ;
    }

    public function store(){

        return $this->belongsTo(Store::class);
    }

    //relationship between order and products many to many  .

    public function products(){

        return $this->belongsToMany(Product::class ,'order_items','order_id','product_id','id','id')
        ->using(OrderItem::class)
        ->as('order_item')
        ->withPivot('product_name','product_price','quantity','options') ;
       
    }

    //address and order has many address relationship .
    public function address(){

        return $this->hasMany(OrderAddress::class ,'order_id','id');
    }

    // we want to get the address of billing via model relationship
    public function billing(){

        return $this->hasOne(OrderAddress::class ,'order_id','id')
        ->where('address_type','pilling');
    }
    // we want to get the address of shipping via model relationship
    public function shipping(){

        return $this->hasOne(OrderAddress::class ,'order_id','id')
        ->where('address_type','shipping');
    }

    public static function getNextNumber(){

        $year=Carbon::now()->year;
        $number=Order::whereYear('created_at','=',$year)->max('order_number');
        if($number){
        
           return $number + 1 ;
        }

        return $year . '0001';

    }
}
