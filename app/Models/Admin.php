<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Foundation\Auth\User;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Admin extends  User
{
    use HasFactory  , Notifiable;


    //fillable for avoiding mass asignment .


    protected $fillable=[

        'name','email', 'username','phone','image','password','super-admin'
    ];

    public function roles(){
        return $this->belongsToMany(Role::class , 'admin_role');
    }

    public function hasAbility($ability){

        return $this->roles()->whereHas('abilities',function($query) use ($ability){
            $query->where('ability','=',$ability)
            ->where('type','=','allow');
        })->exists();
    }
    protected $hidden = [
        'password', 'remember_token',
    ];

     public function getAdminImageAttribute (){

        if(! $this->image){

            return 'https://cdn.pixabay.com/photo/2016/08/08/09/17/avatar-1577909_1280.png';
        }
        if(Str::startsWith( $this->image , ['http://','https://'])){
            return $this->image ;
        }

        return  asset('storage/'.$this->image);

        
    }
}
