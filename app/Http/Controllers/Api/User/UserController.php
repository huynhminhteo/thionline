<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;

class UserController extends Controller
{
    //
    public function __construct()
    {
        $this->instance = $this->instance(\App\Http\Helper\Api\User\Helper::class);
    }

    public function api_add_user(Request $request){
        try{ 
            $rules = [
                'name' => 'required|min:1|max:191',
                'role' =>  'required|in:1,2,3,4,5,6,7,8,9',
                'mail' =>  'required|min:1|max:40|email',
                'password' => 'required|min:1|max:64',
                'uid' =>  'required|min:1|max:191',
            ];

            $msg_rules = [
                'mail.max' => 'メールアドレスが40文字を超えています',
            ];

            $validator = Validator::make($request->all(), $rules, $msg_rules);
    
            if ($validator->fails()) {
                return $this->JsonExportAPI(403, $validator->errors()->first());
            }

            return $this->instance->apiAddUser($request);
        }catch (\Exception $e) {
            $this->__writeLog500($request->ip(), $request->method(), $request->path(), $e);
            return $this->JsonExportAPI(500, config('constant.msg_500'));
        }
    }

    public function api_update_user(Request $request){
        $rules = [
            'name' => 'min:1|max:191',
            'role' =>  'in:1,2,3,4,5,6,7,8,9',
            'mail' =>  'min:1|max:40|email',
            'password' => 'min:1|max:64',
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return $this->JsonExportAPI(403, $validator->errors()->first());
        }

        return $this->instance->apiUpdateUser($request);
    }

    public function api_delete_user(Request $request){
        try{ 
            $rules = [
                'id' => 'required|digits_between:1,10',
                'mail' => 'required|email'
            ];
            $validator = Validator::make($request->all(), $rules);
            
            if ($validator->fails()) {
                return $this->JsonExportAPI(403, $validator->errors()->first());
            }
            return $this->instance->apiDeleteUser($request);
        }catch (\Exception $e) {
            $this->__writeLog500($request->ip(), $request->method(), $request->path(), $e);
            return $this->JsonExportAPI(500, config('constant.msg_500'));
        }
    }

    public function api_get_users(Request $request){
        try{
            return $this->instance->apiGetUsers($request);
        }catch (\Exception $e) {
            $this->__writeLog500($request->ip(), $request->method(), $request->path(), $e);
            return $this->JsonExportAPI(500, config('constant.msg_500'));
        }
    }

    public function api_add_user_operator(Request $request){
        try{ 
            $rules = [
                'name' => 'required|min:1|max:191',
                'role' =>  'required|in:1,2,3,4,5,6,7,8',
                'mail' =>  'required|min:1|max:40|email',
            ];

            $msg_rules = [
                'mail.max' => 'メールアドレスが40文字を超えています',
            ];

            $validator = Validator::make($request->all(), $rules, $msg_rules);
    
            if ($validator->fails()) {
                return $this->JsonExportAPI(403, $validator->errors()->first());
            }

            return $this->instance->apiAddUserOperator($request);
        }catch (\Exception $e) {
            $this->__writeLog500($request->ip(), $request->method(), $request->path(), $e);
            return $this->JsonExportAPI(500, config('constant.msg_500'));
        }
    }
}
