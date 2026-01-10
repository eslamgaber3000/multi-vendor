<?php

namespace App\Providers;

use App\Actions\Fortify\AuthenticateUser;
use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Actions\RedirectIfTwoFactorAuthenticatable;
use Laravel\Fortify\Contracts\LoginResponse;
use Laravel\Fortify\Fortify;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //apply multi-guard 

        $request=request();

        if($request->is('admin/*')){
            Config::set('fortify.guard','admin');
            Config::set('fortify.passwords','admins');
            Config::set('fortify.prefix','admin');
            Config::set('fortify.username','email');
            Fortify::authenticateUsing([  AuthenticateUser ::class, 'authenticate']);

            

            // Config::set('fortify.home','admin/dashboard'); //change the redirect after login if he login as admin
        }

        
        $this->app->instance(LoginResponse::class, new class implements LoginResponse { 
            public function toResponse($request)
            
            {
                //use service container to update redireict response if it admin
                if($request->user('admin')){
                return redirect()->intended('admin/dashboard');
            }
             return redirect('/');

        }

    });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);
        Fortify::redirectUserForTwoFactorAuthenticationUsing(RedirectIfTwoFactorAuthenticatable::class);

        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())).'|'.$request->ip());

            return Limit::perMinute(5)->by($throttleKey);
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });

       
        Fortify::loginView(function(){
            //make custom auth code , and but it in class to separate our code 
            
            if(Config::get('fortify.guard')=='web'){
                return view('front.auth.login');
            }
                return view('auth.login');

        }); // you can path the file name as string or as closure function .

        Fortify::registerView(function(){
            if(Config::get('fortify.guard')=='web'){
                
                return view('front.auth.register');
            }
            return view('auth.register');
        });

        Fortify::requestPasswordResetLinkView(function () {
        return view('auth.forgot-password');
    });

    Fortify::resetPasswordView(function (Request $request) {
        return view('auth.reset-password', ['request' => $request]);
    });

     Fortify::verifyEmailView(function () {
        return view('auth.verify-email');
    });


    Fortify::confirmPasswordView(function(){

        if(Config::get('fortify.guard') == 'web'){
            return view('front.auth.confirm-password');
        }
            return view('auth.confirm-password');

    });

    Fortify::twoFactorChallengeView(function(){
        if(Config::get('fortify.guard') == 'web'){
            return view('front.auth.two-factor-challenge');

        }

    
    });


  
    }

    
}
