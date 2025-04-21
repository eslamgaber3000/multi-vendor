<?php

namespace App\Providers;

use App\Repositories\CartRepository\CartModelRepository;
use App\Repositories\CartRepository\CartRepositoryInterface ;
use Illuminate\Support\ServiceProvider;

class CartServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // we use this function to register in service container
        
        $this->app->bind(CartRepositoryInterface::class,function($app){

            return new CartModelRepository ;
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
