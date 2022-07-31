<?php

namespace App\Http\Controllers\Api\Examination;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;

class ExaminationController extends Controller
{
    public function __construct(){
        $this->instance = $this->instance(\App\Http\Helper\Api\Examination\Helper::class);
    }
    
    public function api_upload_record(Request $request){
        try{
            return $this->instance->apiUploadRecord($request);
        }catch (\Exception $e) {
            $this->__writeLog500($request->ip(), $request->method(), $request->path(), $e);
            return $this->JsonExportAPI(500, config('constant.msg_500'));
        }
    }
}
