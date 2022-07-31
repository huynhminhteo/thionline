<?php

namespace App\Http\Controllers\Api\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;

class CompanyController extends Controller
{
    //
    public function __construct(){
        $this->instance = $this->instance(\App\Http\Helper\Api\Company\Helper::class);
    }
    public function api_get_company(Request $request){
        try{ 
            return $this->instance->apiGetCompany($request);
        }catch (\Exception $e) {
            $this->__writeLog500($request->ip(), $request->method(), $request->path(), $e);
            return $this->JsonExportAPI(500, config('constant.msg_500'));
        }
    }

    public function api_update_company(Request $request){
        try{
            $rules = array(
                'name'      => 'max:100',
                'name_kana' => 'max:100',
                'office_name'=> 'max:100',
                'office_name_kana'=> 'max:100',
                'post_code' => 'max:10',
                'address'   => 'max:100',
                'building'  => 'max:50',
                'phone'     => 'max:15',
                'fax'       => 'max:15',
                'mail'      => ["max:50","regex:/^[\w.!#$%&'*+\/=?^_`{|}~-]+@[\w-]+(?:\.[\w-]+)*$/"]    
            );
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return $this->JsonExportAPI(403, $validator->errors()->first());
            } 

            return $this->instance->apiUpdateCompany($request);
        }catch(\Exception $e){
            $this->__writeLog500($request->ip(), $request->method(), $request->path(), $e);
            return $this->JsonExportAPI(500, config('constant.msg_500'));
        }
    }
}
