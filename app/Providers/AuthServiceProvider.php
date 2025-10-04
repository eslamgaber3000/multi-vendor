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
        Gate::define('category.view',function($user){
            return true;
        });
        Gate::define('category.create',function($user){
            return true;
        });
        Gate::define('category.edit',function($user){
            return true;
        });
        Gate::define('category.delete',function($user){
            return false;
        });

        Gate::define('product.view',function($user){
            return true;
        });
        Gate::define('product.create',function($user){
            return true;
        });
        Gate::define('product.edit',function($user){
            return true;
        });
        Gate::define('product.delete',function($user){
            return false;
        });
        Gate::define('order.view',function($user){
            return true;
        });
        Gate::define('order.create',function($user){
            return true;
        });
        Gate::define('order.edit',function($user){
            return true;
        });
        Gate::define('order.delete',function($user){
            return false;
        });
        Gate::define('role.view',function($user){
            return true;
        });
        Gate::define('role.create',function($user){
            return true;
        });
        Gate::define('role.edit',function($user){
            return true;
        });
        Gate::define('role.delete',function($user){
            return false;
        });
    }
}
