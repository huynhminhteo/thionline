<?php

namespace App\Http\Controllers\Api\External;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;

class ExternalController extends Controller
{
    //
    public function __construct(){
        $this->instance = $this->instance(\App\Http\Helper\Api\External\Helper::class);
    }
    public function api_set_company_info(Request $request){
        try{ 
            $rules = array(
                'office_name'           => 'required',
                'office_name_kana'      => 'required',
                'zip_code'              => 'required',
                'address'               => 'required',
                'tel_no'                => 'required',
                'e-mail'                =>  ["required","max:50","regex:/^[\w.!#$%&'*+\/=?^_`{|}~-]+@[\w-]+(?:\.[\w-]+)*$/"],
                'plan_type'             => 'required',
                'customer_id'           => 'required',
                'settlement_id'        => 'required'
            );
            $msg_rules = [
                'office_name.required' => '事業所名は必須項目です、値を入力してください',
                'office_name_kana.required' => '事業所名（カナ）は必須項目です、値を入力してください',
                'zip_code.required' => '郵便番号は必須項目です、値を入力してください',
                'address.required' => '住所は必須項目です、値を入力してください',
                'tel_no.required' => '電話番号は必須項目です、値を入力してください',
                'plan_type.required' => 'プランタイプは必須項目です、値を入力してください',
                'customer_id.required' => '顧客ID（決済）は必須項目です、値を入力してください',
                'settlement_id.required' => '定期課金IDは必須項目です、値を入力してください',
                'e-mail.required' => 'メールアドレ'.config('constant.field_required'),
                'e-mail.max' => 'メールアドレスが文字数が多すぎます',
                'e-mail.regex' => config('constant.format_email')
            ];


            $validator = Validator::make($request->all(), $rules , $msg_rules);

            if ($validator->fails()) {
                return response()->json([
                    'result' => 403 , 
                    'err_msg' => $validator->errors()->first() 
                ],200);
            }

            return $this->instance->apiSetCompanyInfo($request);
        }catch (\Exception $e) {
            $this->__writeLog500($request->ip(), $request->method(), $request->path(), $e);
            return response()->json([
                'result' => 500 , 
                'err_msg' => config('constant.msg_500') 
            ],200);
        }
    }

    public function api_change_settlement_status(Request $request){
        try{
            $rules = array(
                'customer_id'           => 'required'
            );

            $msg_rules = [
                'customer_id.required' => '顧客ID（決済）は必須項目です、値を入力してください',
            ];

            $validator = Validator::make($request->all(), $rules ,$msg_rules);

            if ($validator->fails()) {
                return response()->json([
                    'result' => 403 , 
                    'err_msg' => $validator->errors()->first() 
                ],200);
            } 

            return $this->instance->apiChangeSettlementStatus($request);
        }catch (\Exception $e) {
            $this->__writeLog500($request->ip(), $request->method(), $request->path(), $e);
            return response()->json([
                'result' => 500 , 
                'err_msg' => config('constant.msg_500') 
            ],200);
        }
    }

    public function api_get_customer_id(Request $request){
        try{
            $rules = array(
                'token'           => 'required',
            );
            $msg_rules = [
                'token.required' => 'tokenは必須項目です、値を入力してください',
            ];
            $validator = Validator::make($request->all(), $rules ,$msg_rules);

            if ($validator->fails()) {
                return response()->json([
                    'result' => 403 , 
                    'err_msg' => $validator->errors()->first() 
                ],200);
            } 
            return $this->instance->apiGetCustomerId($request);
        }catch (\Exception $e) {
            $this->__writeLog500($request->ip(), $request->method(), $request->path(), $e);
            return response()->json([
                'result' => 500 , 
                'err_msg' => config('constant.msg_500') 
            ],200);
        }
    }

    public function api_change_card(Request $request){
        try{
            $rules = array(
                'customer_id'           => 'required',
                'transaction_date'      => 'required',
            );
           
            $msg_rules = [
                'customer_id.required' => '顧客ID（決済）は必須項目です、値を入力してください',
                'transaction_date.required' => '決済予定日は必須項目です、値を入力してください'
            ];

            $validator = Validator::make($request->all(), $rules,$msg_rules);
            if ($validator->fails()) {
                return response()->json([
                    'result' => 403 , 
                    'err_msg' => $validator->errors()->first() 
                ],200);
            } 
            return $this->instance->apiChangeCard($request);
        }catch (\Exception $e) {
            $this->__writeLog500($request->ip(), $request->method(), $request->path(), $e);
            return response()->json([
                'result' => 500 , 
                'err_msg' => config('constant.msg_500') 
            ],200);
        }
    }

    public function api_upgrade_trial(Request $request){
        try{
            return $this->instance->apiUpgradeTrial($request);
        }catch (\Exception $e) {
            $this->__writeLog500($request->ip(), $request->method(), $request->path(), $e);
            return response()->json([
                'result' => 500 , 
                'err_msg' => config('constant.msg_500') 
            ],200);
        }
    }
}
