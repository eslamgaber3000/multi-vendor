<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Profile;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;  //he change the Name of the User Class for solve conflict might happen
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Crypt;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable  , TwoFactorAuthenticatable;  

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
       'image',
       'provider',
       'provider_id',
       'provider_token',   
        
       
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
         'two_factor_secret',
        'two_factor_recovery_codes',
        'two_factor_confirmed_at',
        'provider_token',
        
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'provider_token' => 'encrypted',
    ];


    // using mutator to hash password automaticlly when we set it to database
    // public function setProviderTokenAttribute($value){
    //     $this->attributes['provider_token'] = Crypt::encrypt($value);
    // } 
    
    // using accessor to decrypt provider token when we get it from database
    // public function getProviderTokenAttribute($value){
    //     return Crypt::decrypt($value);
    // }
    public function profile(){
        return $this->hasOne(Profile::class, 'user_id', 'id')->withDefault();
    }
}
