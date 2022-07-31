<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App;
use Auth;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        App::singleton('permission_main', function(){
            if (\Request::is('api/*') || \Request::is('*/webview/*')) {
                $permissionName = auth('api')->user()->getPermissionsViaRoles()->toArray();
            } else if(\Request::is('*/webview/*')) {
                $permissionName = auth('api')->user()->getPermissionsViaRoles()->toArray();
            } else {
                $permissionName = Auth::user()->getPermissionsViaRoles()->toArray();
            }
            $permissionName = new \RecursiveIteratorIterator(new \RecursiveArrayIterator($permissionName));
            return iterator_to_array($permissionName, false);
        });

        App::singleton('role_main', function(){
            if (\Request::is('api/*') || \Request::is('*/webview/*')) {
                $roleName = auth('api')->user()->getRoleNames()->toArray();
            } else if(\Request::is('*/webview/*')) {
                $roleName = auth('api')->user()->getRoleNames()->toArray();
            } else {
                $roleName = Auth::user()->getRoleNames()->toArray();
            }
            $roleName = new \RecursiveIteratorIterator(new \RecursiveArrayIterator($roleName));
            return iterator_to_array($roleName, false);
        });
    }
}
