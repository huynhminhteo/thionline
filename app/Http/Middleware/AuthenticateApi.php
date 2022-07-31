<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Carbon\Carbon;

class AuthenticateApi
{
    protected $except = [
        'api/utils/get'
    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        try {
            if(!$this->inExceptArray($request)) {
                if (!empty($request->header('Authorization'))) {
                    if (strpos($request->header('Authorization'), '.') !== false) {
                        $token = explode('.', $request->header('Authorization'));
                        $user_id = json_decode(base64_decode($token[1]))->sub;
                    } else {
                        if (\Request::is('*/webview/*')) {
                            return redirect()->route('user.page.error.403');
                        }
                        return $this->JsonExportApi(405, config('constant.msg_expire'));
                    }
                    $user = auth('api')->user();
                    if (empty($user)) {
                        if (\Request::is('*/webview/*')) {
                            return redirect()->route('user.page.error.403');
                        }
                        return $this->JsonExportApi(405, config('constant.msg_expire'));
                    }
                } else {
                    if(!empty($request->token)) {
                        $bearer = 'Bearer '.$request->token;
                        if (strpos($bearer, '.') !== false) {
                            $token = explode('.', $bearer);
                            $user_id = json_decode(base64_decode($token[1]))->sub;
                            session(['tokenapi' => $request->token]);
                            session(['user_id' => $user_id]);
                        } else {
                            if (\Request::is('*/webview/*')) {
                                return redirect()->route('user.page.error.403');
                            }
                            return $this->JsonExportApi(405, config('constant.msg_expire'));
                        }
                        $user = auth('api')->user();
                        if (empty($user)) {
                            if (\Request::is('*/webview/*')) {
                                return redirect()->route('user.page.error.403');
                            }
                            return $this->JsonExportApi(405, config('constant.msg_expire'));
                        }
                    } else {
                        if (\Request::is('*/webview/*')) {
                            return redirect()->route('user.page.error.403');
                        }
                        return $this->JsonExportApi(405, config('constant.msg_expire'));
                    }
                }
            }

            return $next($request);
        } catch (\Exception $e) {
            if (\Request::is('*/webview/*')) {
                return redirect()->route('user.page.error.403');
            }
            return $this->JsonExportApi(405, config('constant.msg_expire'));
        }
    }

    static public function JsonExportApi($code, $msg)
    {
        $callback = [
            'msg' => $msg
        ];
        return response()->json($callback, $code, [], JSON_NUMERIC_CHECK);
    }

    protected function inExceptArray($request)
    {
        foreach ($this->except as $except) {
            if ($except !== '/') {
                $except = trim($except, '/');
            }
            if ($request->fullUrlIs($except) || $request->is($except)) {
                return true;
            }
        }

        return false;
    }

}
