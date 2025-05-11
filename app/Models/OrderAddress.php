<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderAddress extends Model
{
    use HasFactory;


    protected $fillable =[


        'order_id','address_type','first_name','last_name','email','mailing_address'
        ,'phone_number','city','postal_code','country','state'
    ];
}
