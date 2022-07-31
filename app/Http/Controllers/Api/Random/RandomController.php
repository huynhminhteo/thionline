<?php

namespace App\Http\Controllers\Api\Random;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;

class RandomController extends Controller
{
    public function __construct(){
        $this->instance = $this->instance(\App\Http\Helper\Api\Random\Helper::class);
    }
    
    public function api_random(Request $request){
        try{
            return $this->instance->apiRandom($request);
        }catch (\Exception $e) {
            $this->__writeLog500($request->ip(), $request->method(), $request->path(), $e);
            return $this->JsonExportAPI(500, config('constant.msg_500'));
        }
    }
}
