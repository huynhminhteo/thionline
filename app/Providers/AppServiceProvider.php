<?php

namespace App\Providers;

use App;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Validator;
use App\Model;
use Auth;
use Cookie;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Cache\NullStore;
use Cache;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //check that app is local
        if (!$this->app->isLocal()) {
            //else register your services you require for production
            $this->app['request']->server->set('HTTPS', true);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if(env('APP_PROD') === true) {
            \URL::forceScheme('https');
        }

        view()->composer('*',function($view) {
            $token = Cookie::get('_token_mainte');
            if(!empty($token)){
                $payload = explode('|',$token);
                $user = $this->getInfoUserCookie($token);
                $view->with('user', $user);
                $view->with('_token_mainte', $payload[0]);
            }
        });
        Cache::extend('none', function ($app) {
            return Cache::repository(new NullStore);
        });
        // date_default_timezone_set('Asia/Tokyo');
        Schema::defaultStringLength(191);

        Validator::extend('lat', function ($attribute, $value, $parameters, $validator) {
            return preg_match('/^(\+|-)?(?:90(?:(?:\.0{1,20})?)|(?:[0-9]|[1-8][0-9])(?:(?:\.[0-9]{1,20})?))$/', $value);
        });

        Validator::extend('lng', function ($attribute, $value, $parameters, $validator) {
            return preg_match('/^(\+|-)?(?:180(?:(?:\.0{1,20})?)|(?:[0-9]|[1-9][0-9]|1[0-7][0-9])(?:(?:\.[0-9]{1,20})?))$/', $value);
        });

        Validator::extend('phonevn', function ($attribute, $value, $parameters, $validator) {
            return preg_match('/(09[0|1|2|3|4|5|6|7|8|9]|07[0|1|2|3|4|5|6|7|8|9]|08[0|1|2|3|4|5|6|7|8|9]|03[0|1|2|3|4|5|6|7|8|9]|05[0|1|2|3|4|5|6|7|8|9])+([0-9]{7,8})/', $value);
        });
    }

    static public function getInfoUserCookie($token)
    {
        if(strpos($token, '|') !== false) {
            $tokenParts = explode("|", $token);
            if(isset($tokenParts[1])){
                $tokenUser = Crypt::decryptString($tokenParts[1]);
                $user = json_decode($tokenUser,true);
                $user_return = Model\MUser::withTrashed()->find($user['id']);
                return $user_return;
            }
            return null;
        } else {
            return null;
        }
    }
}
