<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Pagination\Paginator;
use Validator;
use Carbon\Carbon;
use phpseclib\Crypt\RSA;
use Intervention\Image\ImageManagerStatic as Image;
use GrahamCampbell\Throttle\Facades\Throttle;
use Faker\Generator as Faker;
use App\Jobs\Otp;
use Hash;
use App\Jobs\InitData;

class AuthController extends Controller
{
    protected $instance;

    public function __construct()
    {
        $this->instance = $this->instance(\App\Http\Helper\Api\Auth\Helper::class);
    }

    public function api_index(Request $request){
        return true;
    }

    public function api_init(Request $request){
        return $request->user();
    }

    public function api_logout(Request $request){
        $rules = array(
            'device_id' => 'required|min:1|max:128'
        );

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return $this->JsonExport(403, $validator->errors()->first());
        } else {
            return $this->instance->api_logout($request);
        }
    }

    public function api_change_password(Request $request){
        $rules = array(
            'password' => 'required|max:64|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*)(?=.*?[#?!@$%^&*-_]).{8,}$/',
        );
        $msg_rules = [
            'password.required' => 'パスワード'.config('constant.field_required'),
            'password.max' => 'パスワードが長すぎます',
            'password.regex' => 'パスワードは半角英数字記号8文字以上で記号大文字小文字がそれぞれ一つは必要です',
        ];
        $validator = Validator::make($request->all(), $rules ,$msg_rules);
        if ($validator->fails()) {
            return $this->JsonExportAPI(403, $validator->errors()->first());
        } else {
            return $this->instance->apiChangePassword($request);
        }
    }

    public function api_forgot_admin(Request $request){
        try{
            $rules = array(
                'mail' => ["required","max:40","regex:/^[\w.!#$%&'*+\/=?^_`{|}~-]+@[\w-]+(?:\.[\w-]+)*$/"],
                'companyId' => 'required'
            );
            $msg_rules = [
                'mail.max' => 'メールアドレスが40文字を超えています',
                'mail.required' => 'メールアドレ'.config('constant.field_required'),
                'mail.regex' => config('constant.format_email'),
            ];
            $validator = Validator::make($request->all(), $rules ,$msg_rules);
            if ($validator->fails()) {
                return $this->JsonExportAPI(403, $validator->errors()->first());
            } else {
                return $this->instance->apiForgotPasswordAdmin($request);
            }
        }catch(\Exception $e){
            $this->__writeLog500($request->ip(), $request->method(), $request->path(), $e);
            return $this->JsonExportAPI(500, config('constant.msg_500'));
        }
    }

    public function api_check_user(Request $request){
        try{
            $rules = array(
                'id'   => 'required',
                'mail' => ["required","max:40","regex:/^[\w.!#$%&'*+\/=?^_`{|}~-]+@[\w-]+(?:\.[\w-]+)*$/"],
            );
            $msg_rules = [
                'mail.required' => 'メールアドレ'.config('constant.field_required'),
                'mail.regex' => config('constant.format_email'),
            ];
            $validator = Validator::make($request->all(), $rules ,$msg_rules);
            if ($validator->fails()) {
                return $this->JsonExportAPI(403, $validator->errors()->first());
            } else {
                return $this->instance->apiCheckUser($request);
            }
        }catch(\Exception $e){
            $this->__writeLog500($request->ip(), $request->method(), $request->path(), $e);
            return $this->JsonExportAPI(500, config('constant.msg_500'));
        }
    }

    public function api_reset_password(Request $request){
        try{
            $rules = array(
                'mail' => ["required","max:40","regex:/^[\w.!#$%&'*+\/=?^_`{|}~-]+@[\w-]+(?:\.[\w-]+)*$/"],
                'password' => 'required|max:64|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*)(?=.*?[#?!@$%^&*-_]).{8,}$/',
                'id'    => 'required'
            );
            $msg_rules = [
                'mail.required' => 'メールアドレ'.config('constant.field_required'),
                'mail.regex' => config('constant.format_email'),
                'password.required' => 'パスワード'.config('constant.field_required'),
                'password.max' => 'パスワードが長すぎます',
                'password.regex' => 'パスワードは半角英数字記号8文字以上で記号大文字小文字がそれぞれ一つは必要です',
            ];
            $validator = Validator::make($request->all(), $rules ,$msg_rules);
            if ($validator->fails()) {
                return $this->JsonExportAPI(403, $validator->errors()->first());
            } else {
                return $this->instance->apiResetPassword($request);
            }
        }catch(\Exception $e){
            $this->__writeLog500($request->ip(), $request->method(), $request->path(), $e);
            return $this->JsonExportAPI(500, config('constant.msg_500'));
        }
    }

    //OPERATOR
    public function api_login_operator(Request $request){   
        try {
            $rules = array(
                'mail' => ["required","max:40","regex:/^[\w.!#$%&'*+\/=?^_`{|}~-]+@[\w-]+(?:\.[\w-]+)*$/"],
                'password' => 'required|min:1|max:64',
            );
            $msg_rules = [
                'mail.required' => 'メールアドレ'.config('constant.field_required'),
                'mail.regex' => config('constant.format_email'),
                'password.required' => 'パスワードが必要です',
                'password.min' => 'パスワードが短すぎる',
                'password.max' => 'パスワードが長すぎます'
            ];
           
            $validator = Validator::make($request->all(), $rules, $msg_rules);
            if ($validator->fails()) {
                return $this->JsonExportAPI(403, $validator->errors()->first());
            } else {
                return $this->instance->apiLoginOperator($request);
            }
        } catch (\Exception $e) {
            $this->__writeLog500($request->ip(), $request->method(), $request->path(), $e);
            return $this->JsonExportAPI(500, config('constant.msg_500'));
        }
    }

    public function api_change_pw_admin(Request $request){
        try{
            $rules = array(
                'oldpass' => 'required',
                'newpass' => 'required|min:8|max:64|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*)(?=.*?[#?!@$%^&*-_]).{8,}$/',
            );
            $msg_rules = [
                'required' => 'パスワードが必要です',
                'min' => 'パスワードは半角英数字記号8文字以上で記号大文字小文字がそれぞれ一つは必要です',
                'max' => 'パスワードが長すぎます',
                'regex' => 'パスワードは半角英数字記号8文字以上で記号大文字小文字がそれぞれ一つは必要です',
            ];
            $validator = Validator::make($request->all(), $rules, $msg_rules);
            if ($validator->fails()) {
                return $this->JsonExportAPI(403, $validator->errors()->first());
            } else {
                return $this->instance->changePasswordAdmin($request);
            }
        }catch(\Exception $e){
            $this->__writeLog500($request->ip(), $request->method(), $request->path(), $e);
            return $this->JsonExportAPI(500, config('constant.msg_500'));
        }
    }
}