<?php

namespace App\Http\Controllers\Api\Test;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;

class TestController extends Controller
{
    public function __construct(){
        $this->instance = $this->instance(\App\Http\Helper\Api\Test\Helper::class);
    }
    
    public function api_get_list_test(Request $request){
        try{
            return $this->instance->apiGetListTest($request);
        }catch (\Exception $e) {
            $this->__writeLog500($request->ip(), $request->method(), $request->path(), $e);
            return $this->JsonExportAPI(500, config('constant.msg_500'));
        }
    }
}
