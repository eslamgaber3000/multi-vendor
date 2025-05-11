<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class OrderItem extends Pivot
{
    use HasFactory;

    public $incrementing = True;

    protected $table ='order_items';


    //Relationships product :
    public function product(){

        return $this->belongsTo(Product::class)
        ->withDefault([

            'name'=>$this->product_name
        ]);
    }  

    //Relationships product 

    public function order(){

        return $this->belongsTo(Order::class);
        
    }  

    
    //product() relationship || order relation

}
