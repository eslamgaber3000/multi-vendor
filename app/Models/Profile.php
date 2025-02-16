<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $fillable=[
       "user_id", "first_name","last_name","birthdate","gender","country","state","city"
       ,"postal_code","street_address","local"
    ];


    //create relationship between user and profile every user has one profile

    public function user(){
        return $this->belongsTo(User::class);
    }
}
