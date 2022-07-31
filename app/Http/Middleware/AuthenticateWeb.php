<?php

namespace App\Http\Middleware;

use Closure;
use Cookie;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Config;

class AuthenticateWeb
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $token = $request->cookie('_token_mainte'); 
        if(empty($token)){
            return redirect('/login');
        }

        return $next($request);
    }
    
}
