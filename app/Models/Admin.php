<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User;
use Illuminate\Notifications\Notifiable;

class Admin extends  User
{
    use HasFactory  , Notifiable;


    //fillable for avoiding mass asignment .


    protected $fillable=[

        'name','email', 'username','phone','image','password','super-admin'
    ];
}
