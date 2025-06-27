<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\Intl\Countries;

class OrderAddress extends Model
{
    use HasFactory;
    public $timestamps =false ;

    protected $fillable =[


        'order_id','address_type','first_name','last_name','email','mailing_address'
        ,'phone_number','city','postal_code','country','state'
    ];

    public function getNameAttribute(){

        return $this->first_name." ".$this->last_name ;
    }


    // make country accessor .

    public function getCountryNameAttribute(){
        return Countries::getName($this->country);
    }
}
