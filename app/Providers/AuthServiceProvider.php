<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {


        // it should take abilities stands of role

        foreach (config('permissions') as $abilities_code => $value) {

            Gate::define($abilities_code , function ($user) use ($abilities_code) {
               //this should return true or false -1
               // if role of this user has ability and this ability == ability_code //result should = true .
                return  $user->hasAbility($abilities_code);

            });
        }
            
        // Gate::define('category.view',function($user){
        //     return true;
        // });
        // Gate::define('category.create',function($user){
        //     return false;
        // });
        // Gate::define('category.edit',function($user){
        //     return true;
        // });
        // Gate::define('category.delete',function($user){
        //     return false;
        // });

        // Gate::define('product.view',function($user){
        //     return true;
        // });
        // Gate::define('product.create',function($user){
        //     return true;
        // });
        // Gate::define('product.edit',function($user){
        //     return true;
        // });
        // Gate::define('product.delete',function($user){
        //     return false;
        // });
        // Gate::define('order.view',function($user){
        //     return true;
        // });
        // Gate::define('order.create',function($user){
        //     return true;
        // });
        // Gate::define('order.edit',function($user){
        //     return true;
        // });
        // Gate::define('order.delete',function($user){
        //     return false;
        // });

        // // Gate::define('role.view',function($user){
        // //     return true;
        // // });

        // // Gate::define('role.create',function($user){
        // //     return true;
        // // });
        // // Gate::define('role.edit',function($user){
        // //     return true;
        // // });
        // // Gate::define('role.delete',function($user){
        // //     return true;
        // // });

        // Gate::define('Admins.view',function($user){
        //     return true;
        // });
        // Gate::define('Admins.create',function($user){
        //     return true;
        // });
        // Gate::define('Admins.edit',function($user){
        //     return true;
        // });
        // Gate::define('Admins.delete',function($user){
        //     return true;
        // });
      
    }
}
