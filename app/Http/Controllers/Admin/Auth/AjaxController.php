<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AjaxController extends Controller
{
    //
    protected $instance;

    public function __construct()
    {
        $this->instance = $this->instance(\App\Http\Helper\Admin\Auth\Helper::class);
    }

    public function ajax_login(Request $request){
        try {
            return $this->instance->ajaxLogin($request);
        } catch (\Exception $e) {
            $this->__writeLog500($request->ip(), $request->method(), $request->path(), $e);
            return self::JsonExport(500, config('constant.msg_500'));
        }
    }

    public function ajax_forgot(Request $request){
        try {
            return $this->instance->ajaxForgot($request);
        } catch (\Exception $e) {
            $this->__writeLog500($request->ip(), $request->method(), $request->path(), $e);
            return self::JsonExport(500, config('constant.msg_500'));
        }
    }
}
