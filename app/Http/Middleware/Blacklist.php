<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Illuminate\Support\Facades\Storage;

class Blacklist
{
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
            if (!empty($request->header('Authorization'))) {
                $token = str_replace("Bearer ", "", $request->header('Authorization'));
            } else if(!empty($request->token)){
                $token = $request->token;
            } else {
                if (\Request::is('*/webview/*')) {
                    return redirect()->route('user.page.error.403');
                }
                return $this->JsonExportApi(405, config('constant.msg_expire'));
            }
            
            $check = Storage::disk('blacklist')->exists(md5($token));
            if ($check) {
                if (\Request::is('*/webview/*')) {
                    return redirect()->route('user.page.error.403');
                }
                return $this->JsonExportApi(405, config('constant.msg_expire'));
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
}
