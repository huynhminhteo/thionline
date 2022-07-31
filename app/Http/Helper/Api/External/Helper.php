<?php

namespace App\Http\Helper\Api\External;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use App\Http\Helper\Helper as HelperBase;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Yajra\Datatables\Datatables;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\Filter;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Hash;
use Auth;
use Carbon\Carbon;
use \stdClass;
use App\Model;
use Storage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Crypt;
use App\Jobs\FinishContract;
use App\Jobs\ChangeCard;
use App\Jobs\ChangeSettlementStatus;
use Illuminate\Support\Facades\Log;

class Helper extends HelperBase
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        parent::__construct();
    }

    public function apiSetCompanyInfo($request){
        try{
            // $check_email = Model\MUser::whereMail($request['e-mail'])
            // ->first();
            $company_name = '';
            $company_name_kana = '';
            $building_name = '';
            $fax_no = '';
            $account_manager_name = '';
            $trial = false;

            // if($check_email){
            //     if(env('LOG_EXTERNAL_API')) {
            //         $this->__writeLogExternal($request, 403, "メールアドレスはすでに登録されています");
            //     }
            //     return response()->json([
            //         'result' => 403 ,
            //         'err_msg' => 'メールアドレスはすでに登録されています' 
            //     ],200);
            // }

            $admin_maite = Model\MUser::whereRole(1)
            ->first();
            // generate corp_id
            $alpha = array_merge(range('a','z'),range('A','Z'));
            $numeric = range(0,9);
            $check_corp_id = true;
            while($check_corp_id){
                $cord_id = implode('',$this->array_random($alpha,3)).implode('',$this->array_random($numeric,3));
                $check_company = Model\MCompany::whereCorpId($cord_id)->first();
                if(!$check_company){
                    $check_corp_id = false;
                }
            }
            $schemaName = 'home_medical_'.$cord_id;
            // List Plan & id compare ID plan in DATABASE OPERATOR
            $plan_type = [
                1 => 'lite',
                2 => 'standard',
                3 => 'premium'
            ];

            $plan_type_trial = [
                1 => 'lite_trial',
                2 => 'standard_trial',
                3 => 'premium_trial'
            ];
            $plan_id = array_search($request->plan_type,$plan_type);

            if(in_array($request->plan_type,$plan_type) === false){
                if(in_array($request->plan_type,$plan_type_trial) === false){
                    if(env('LOG_EXTERNAL_API')) {
                        $this->__writeLogExternal($request, 403, "プランが存在しません");
                    }
                    return response()->json([
                        'result' => 403 ,
                        'err_msg' => 'プランが存在しません' 
                    ],200);
                }
            }
            if(in_array($request->plan_type,$plan_type_trial)){
                $trial = true;
                $plan_id = array_search($request->plan_type,$plan_type_trial);
            }
          
            if($this->createDBCorp($schemaName)){
                DB::beginTransaction();
                $check_plan = Model\MPlan::find($plan_id);
                if(!$check_plan){
                    if(env('LOG_EXTERNAL_API')) {
                        $this->__writeLogExternal($request, 403, "プランが存在しません");
                    }
                    return response()->json([
                        'result' => 403 ,
                        'err_msg' => 'プランが存在しません' 
                    ],200);
                }
                
                if($request->has('company_name')){
                    $company_name = $request->company_name ?? '';
                }
                if($request->has('company_name_kana')){
                    $company_name_kana = $request->company_name_kana ?? '';
                }
                if($request->has('building_name')){
                    $building_name = $request->building_name ?? '';
                }
                if($request->has('fax_no')){
                    $fax_no = $request->fax_no ?? '';
                }
                if(isset($request['account_manager_name'])){
                    $account_manager_name =  $request['account_manager_name'] ?? '';
                }
                 $data = [
                    'insert_user'               => $admin_maite->id,
                    'update_user'               => $admin_maite->id,
                    'office_name'               => $request->office_name,
                    'office_name_kana'          => $request->office_name_kana,
                    'name'                      => $company_name,
                    'name_kana'                 => $company_name_kana,
                    'post_code'                 => $request->zip_code,
                    'address'                   => $request->address,
                    'building'                  => $building_name,
                    'phone'                     => $request->tel_no,
                    'fax'                       => $fax_no,
                    'mail'                      => $request['e-mail'],
                    'account_manager_name'      => $account_manager_name,
                    'corp_id'                   => $cord_id,
                    'status'                    => 1,
                    'contract_date'             => Carbon::now()
                ];  
                
                $company = Model\MCompany::create($data);
            
                $data_contract = [
                    'insert_user'               => $admin_maite->id,
                    'update_user'               => $admin_maite->id,
                    'company_id'                => $company->id,
                    'contract_year'             => Carbon::now()->format('Y'),
                    'contract_month'            => Carbon::now()->format('n'),
                    'plan_id'                   => $check_plan->id,
                    'amount'                    => $check_plan->amount,
                    'regular_charge_id'         => $request->settlement_id,
                    'charge_client_id'          => $request->customer_id,
                    'status'                    => 1
                ];
                if($trial){
                    $data_contract['is_trial'] = 1;
                }else{
                    $data_contract['is_trial'] = 0;
                }
                // create contract in month register
                Model\TContract::create($data_contract);
                // create contract in next month register
                $data_contract['contract_year'] = Carbon::now()->addMonths(1)->format('Y');
                $data_contract['contract_month'] = Carbon::now()->addMonths(1)->format('n');
                $data_contract['status'] = 0;
                
                Model\TContract::create($data_contract);

                // Create account & Send mail to user 
                $data_user = [
                    'insert_user'               => $admin_maite->id,
                    'update_user'               => $admin_maite->id,
                    'mail'                      => $request['e-mail'],
                    'password'                  => '',
                    'role'                      => 3,
                    'company_id'                => $company->id,
                    'name'                      => $request['account_manager_name'] ?? '',
                    'status'                    => 1
                ];

                $user_map = Model\MUser::create($data_user);
             
                // Insert config DB Company
                $data_db = [
                    'insert_user'               => $admin_maite->id,
                    'update_user'               => $admin_maite->id,
                    'company_id'                => $company->id,
                    'host'                      => env('DB_HOST_MYSQL','127.0.0.1'),
                    'port'                      => env('DB_PORT_MYSQL',3306),
                    'database'                  => $schemaName,
                    'username'                  => env('DB_USERNAME_MYSQL','root'),
                    'password'                  => env('DB_PASSWORD_MYSQL','root'),
                    'status'                    => 1
                ];

                $company_db = Model\MDatabaseCompany::create($data_db);

                $url = config('constant.admin_url').'/api/company/init/v1';
                $data_post  = [
                    'db'        => $data_db,
                    'user'      => $data_user,
                    'user_map'  => $user_map->id
                ];
                $response = Http::withOptions(['verify' => false])->post($url,$data_post);
           
                $data_callback = $response->json();
                if($response->status() == 200){
                    $user_map->update([
                        'uid'   => $data_callback['data']['uid'],
                        'password'  => Hash::make($data_callback['data']['password_tmp'])
                    ]);
            
                    FinishContract::dispatch($request->office_name,$cord_id,$request['e-mail'],$data_callback['data']['password_tmp']);
                }else{
                    DB::rollBack();
                    if(env('LOG_EXTERNAL_API')) {
                        Log::channel('external')->error($request->ip().' - "'.$request->method().' /'.$request->path().'"'."\n". 'Request Parameter:'."\n".$request->getContent()."\n". 'Response Parameter:'."\n".'{"code" : '.$response->status().', "msg" : "'.$data_callback['msg'].'"}');
                    }
                    return response()->json([
                        'result' => $response->status() , 
                        'err_msg' => $data_callback['msg']
                    ],200);
                } 

                // Insert config DB Company
                // Create account & Send mail to user end

                DB::commit();
                if(env('LOG_EXTERNAL_API')) {
                    Log::channel('external')->error($request->ip().' - "'.$request->method().' /'.$request->path().'"'."\n". 'Request Parameter:'."\n".$request->getContent()."\n". 'Response Parameter:'."\n".'{"code" : 200, "msg" : "'.config('constant.msg_200').'"}');
                }
                return response()->json([
                    'result' => 0 ,
                    'err_msg' => config('constant.msg_200') 
                ],200);
            }

        }catch (\Exception $e) {
            DB::rollback();
            if(env('LOG_EXTERNAL_API')) {
                Log::channel('external')->error($request->ip().' - "'.$request->method().' /'.$request->path().'"'."\n". 'Request Parameter:'."\n".$request->getContent()."\n". 'Response Parameter:'."\n".'{"code" : 500, "msg" : "'.$e->getMessage().'"}');
            }
            return response()->json([
                'result' => 500 , 
                'err_msg' => config('constant.msg_500') 
            ],200);
        }
    }

    public function apiChangeSettlementStatus($request){
        try{
            $admin_maite = Model\MUser::whereRole(1)
            ->first();

            $check_customer = Model\TContract::where('charge_client_id',$request->customer_id)
            ->orderBy('id','desc')
            ->first();

            if(!$check_customer){
                if(env('LOG_EXTERNAL_API')) {
                    $this->__writeLogExternal($request, 403, "ユーザーが存在しません");
                }
                return response()->json([
                    'result' => 403 ,
                    'err_msg' => 'ユーザーが存在しません' 
                ],200);
            }
            DB::beginTransaction();
            $plan_type = [
                1 => 'lite',
                2 => 'standard',
                3 => 'premium'
            ];
            if($request->has('next_plan_type') && !empty($request->next_plan_type)){
                $next_plan = $request->next_plan_type;
                if(in_array($next_plan,$plan_type) === false){
                    if(env('LOG_EXTERNAL_API')) {
                        $this->__writeLogExternal($request, 403, "プランが存在しません");
                    }
                    return response()->json([
                        'result' => 403 ,
                        'err_msg' => 'プランが存在しません' 
                    ],200);
                }
                $check_next_plan = Model\MPlan::find(array_search($next_plan,$plan_type));
                if(!$check_next_plan){
                    if(env('LOG_EXTERNAL_API')) {
                        $this->__writeLogExternal($request, 403, "プランが存在しません");
                    }
                    return response()->json([
                        'result' => 403 ,
                        'err_msg' => 'プランが存在しません' 
                    ],200);
                }
                $check_next_plan = $check_next_plan->id;
            }else{
                $check_next_plan = $check_customer->plan_id;
            }
         
            $data = [
                'insert_user'               => $admin_maite->id,
                'update_user'               => $admin_maite->id,
                'company_id'                => $check_customer->mCompany->id,
                'action_status'             => 0,
                'plan_id'                   => $check_next_plan,
                'status'                    => 0,
                'regular_charge_id'         => $request->settlement_id ?? '',
                'charge_client_id'          => $request->customer_id
            ];
            $billing_deadline = Carbon::createFromTimestamp($request->billing_deadline)->format('Y年m月d日');
            if($request->has('usage_status')){
                if($request->usage_status == 0){
                    if($check_customer->mCompany->status == 2){
                        $check_customer->mCompany->update([
                            'status' => 1
                        ]);  
                        $data['action_status'] = 1;
                        ChangeSettlementStatus::dispatch($check_customer->mCompany->mail,$check_customer->mCompany->id,'pay_limit',$billing_deadline,$check_next_plan); 
                    }else{
                        // send mail pay money
                        ChangeSettlementStatus::dispatch($check_customer->mCompany->mail,$check_customer->mCompany->id,'pay',$billing_deadline,$check_next_plan); 
                    }
                   
                }
            
                if($request->usage_status == 1){
                    $check_cancel_contract = Model\TCompanyTransaction::whereCompanyId($check_customer->mCompany->id)
                    ->whereActionStatus(0)
                    ->whereStatus(2)
                    ->first();
    
                    if($check_cancel_contract){
                        // send mail cancel contract
                        ChangeSettlementStatus::dispatch($check_customer->mCompany->mail,$check_customer->mCompany->id,'cancel',$billing_deadline);     
                        $data['action_status'] = 1;  
                    }else{
                        // send mail no pay money
                        ChangeSettlementStatus::dispatch($check_customer->mCompany->mail,$check_customer->mCompany->id,'no_pay',$billing_deadline);       
                    }
                    $data['status'] = 1;
                }
               
                if($request->usage_status == 2){
                    $check_customer->mCompany->update([
                        'status' => 0,
                        'cancel_contract_date' => Carbon::now()
                    ]);
                    $contract = $check_customer->mCompany->tContracts;
                    if($contract){
                        if($contract->status == 0){
                            $data_contract_update = [
                                'status' => 3
                            ];
                        }
                        if($contract->status == 1){
                            $data_contract_update = [
                                'status' => 2
                            ];
                        }
                        if(isset($data_contract_update)){
                            $contract->update($data_contract_update);
                        }
                    }
                    $data['status'] = 2;
                    $data['action_status'] = 1;
                } 
            }

            $comp_trans_exist = Model\TCompanyTransaction::whereCompanyId($check_customer->mCompany->id)
            ->whereIn('action_status', [0,2])
            ->orderBy('id', 'desc')
            ->first();

            if ($comp_trans_exist) {
                if (!$request->has('next_plan_type') || empty($request->next_plan_type)) {
                    unset($data['plan_id']);
                }
                $comp_trans_exist->update($data);
            } else {
                Model\TCompanyTransaction::create($data);
            }

            DB::commit();
            if(env('LOG_EXTERNAL_API')) {
                $this->__writeLogExternal($request, 200, config('constant.msg_200'));
            }
            return response()->json([
                'result' => 0 ,
                'err_msg' => config('constant.msg_200') 
            ],200);
           
        }catch(\Exception $e){
            DB::rollBack();
            if(env('LOG_EXTERNAL_API')) {
                $this->__writeLogExternal($request, 500, config('constant.msg_500'));
            }
            return response()->json([
                'result' => 500 , 
                'err_msg' => config('constant.msg_500') 
            ],200);
        }
    }

    public function apiGetCustomerId($request){
        try{
            $token_decrypt = base64_decode($request->token);
            if (strpos($token_decrypt, '|') !== false) {
                $token_decrypt = explode('|', $token_decrypt);
                $personal_id = $token_decrypt[0];
                $mail = $token_decrypt[1];
                $time = $token_decrypt[2];
                $hash = $token_decrypt[3];
                $md5 = md5($personal_id . $mail . $time);

                if (time() - $time > 60) {
                    if(env('LOG_EXTERNAL_API')) {
                        $this->__writeLogExternal($request, 403, 'ログインセッションが切れました');
                    }
                    return response()->json([
                        'result' => 403 ,
                        'err_msg' => 'ログインセッションが切れました' 
                    ],200);
                }
               
                if ($md5 !== $hash) {
                    if(env('LOG_EXTERNAL_API')) {
                        $this->__writeLogExternal($request, 400, 'システムに異常が発生しました、運営会社に連絡をお願いします');
                    }
                    return response()->json([
                        'result' => 400 , 
                        'err_msg' => 'システムに異常が発生しました、運営会社に連絡をお願いします'
                    ],200);
                }
            
                $check_user = Model\MUser::whereId($personal_id)->whereMail($mail)->with('company.tContracts')->first();
                if(!$check_user){
                    if(env('LOG_EXTERNAL_API')) {
                        $this->__writeLogExternal($request, 403, 'ユーザーが存在しません');
                    }
                    return response()->json([
                        'result' => 403 ,
                        'err_msg' => 'ユーザーが存在しません' 
                    ],200);
                }
                $plan_type = [
                    1 => 'lite',
                    2 => 'standard',
                    3 => 'premium'
                ];
                if(empty($check_user->company->tContracts)){
                    if(env('LOG_EXTERNAL_API')) {
                        $this->__writeLogExternal($request, 400, 'システムに異常が発生しました、運営会社に連絡をお願いします');
                    }
                    return response()->json([
                        'result' => 400 , 
                        'err_msg' => 'システムに異常が発生しました、運営会社に連絡をお願いします'
                    ],200);
                }
                if(env('LOG_EXTERNAL_API')) {
                    $this->__writeLogExternal($request, 200, config('constant.msg_200'));
                }
                return response()->json([
                    'result' => 0 ,
                    'customer_id' => $check_user->company->tContracts->charge_client_id ?? '',
                    'office_id'   => $check_user->company->id,
                    'office_name' => $check_user->company->office_name,
                    'office_name_kana' => $check_user->company->office_name_kana,
                    'company_name' => $check_user->company->name,
                    'company_name_kana' => $check_user->company->name_kana,
                    'zip_code' => $check_user->company->post_code,
                    'address' => $check_user->company->address,
                    'building_name' => $check_user->company->building,
                    'tel_no' => $check_user->company->phone,
                    'fax_no' => $check_user->company->fax,
                    'e-mail' => $check_user->company->mail,
                    'plan_type' => isset($check_user->company->tContracts->plan_id) ? $plan_type[$check_user->company->tContracts->plan_id] : '',
                    "account manager_name" => $check_user->company->account_manager_name,
                    "settlement_id" => $check_user->company->tContracts->regular_charge_id,
                    'err_msg' => config('constant.msg_200') 
                ],200);
            } else {
                if(env('LOG_EXTERNAL_API')) {
                    $this->__writeLogExternal($request, 400, 'システムに異常が発生しました、運営会社に連絡をお願いします');
                }
                return response()->json([
                    'result' => 400 , 
                    'err_msg' => 'システムに異常が発生しました、運営会社に連絡をお願いします'
                ],200);
            }
        }catch (\Exception $e) {
            if(env('LOG_EXTERNAL_API')) {
                $this->__writeLogExternal($request, 500, config('constant.msg_500'));
            }
            return response()->json([
                'result' => 500 , 
                'err_msg' => config('constant.msg_500') 
            ],200);
        }
    }

    public function apiChangeCard($request){
        try{
            $check_customer = Model\TContract::where('charge_client_id', $request->customer_id)
            ->orderBy('id','desc')
            ->first();
            if(!$check_customer){
                if(env('LOG_EXTERNAL_API')) {
                    $this->__writeLogExternal($request, 403, 'ユーザーが存在しません');
                }
                return response()->json([
                    'result' => 403 ,
                    'err_msg' => 'ユーザーが存在しません' 
                ],200);
            }
            $company_name = $check_customer->mCompany->office_name;
            $mail = $check_customer->mCompany->mail;
            $plan_name = $check_customer->mPlan->name;
            $contract_date = Carbon::parse($check_customer->contract_year.'-'.$check_customer->contract_month)->startOfMonth()->format('Y年m月d日')
            . ' ~ ' .
            Carbon::parse($check_customer->contract_year.'-'.$check_customer->contract_month)->endOfMonth()->format('Y年m月d日');

            ChangeCard::dispatch($mail,$company_name,$plan_name,$contract_date,$request->transaction_date);
            if(env('LOG_EXTERNAL_API')) {
                $this->__writeLogExternal($request, 200, config('constant.msg_200'));
            }
            return response()->json([
                'result' => 0 ,
                'err_msg' => config('constant.msg_200') 
            ],200);
        }catch (\Exception $e) {
            DB::rollback();
            if(env('LOG_EXTERNAL_API')) {
                $this->__writeLogExternal($request, 500, config('constant.msg_500'));
            }
            return response()->json([
                'result' => 500 , 
                'err_msg' => config('constant.msg_500') 
            ],200);
        }
    }

    public function array_random($array, $amount = 1){
        $keys = array_rand($array, $amount);
    
        if ($amount == 1) {
            return $array[$keys];
        }
    
        $results = [];
        foreach ($keys as $key) {
            $results[] = $array[$key];
        }
    
        return $results;
    }

    public function createDBCorp($schemaName){
        try{
            $charset = config("database.connections.mysql.charset",'utf8mb4');
            $collation = config("database.connections.mysql.collation",'utf8mb4_unicode_ci');

            config(["database.connections.mysql.database" => null]);

            $query = "CREATE DATABASE IF NOT EXISTS $schemaName CHARACTER SET $charset COLLATE $collation;";

            DB::statement($query);
            return true;
        }catch(\Exception $e){
            return false;
        }
    }

    public function deleteDBCorp($schemaName){
        try{
            config(["database.connections.mysql.database" => null]);

            $query = "DROP DATABASE $schemaName;";

            DB::statement($query);
            return true;
        }catch(\Exception $e){
            return false;
        }
    }

    public function apiUpgradeTrial(Request $request){
        try{
            $company_trial = Model\MCompany::whereHas('tContracts',function($query){
                $query->whereIsTrial(1);
            })
            ->get();
            DB::beginTransaction();
            foreach($company_trial as $value){
                $value->tContracts->update(['is_trial'=>  0]);
            }

            DB::commit();
            if(env('LOG_EXTERNAL_API')) {
                $this->__writeLogExternal($request, 200, config('constant.msg_200'));
            }
            return response()->json([
                'result' => 0 ,
                'err_msg' => config('constant.msg_200') 
            ],200);
        }catch (\Exception $e) {
            DB::rollback();
            if(env('LOG_EXTERNAL_API')) {
                $this->__writeLogExternal($request, 500, config('constant.msg_500'));
            }
            return response()->json([
                'result' => 500 , 
                'err_msg' => config('constant.msg_500') 
            ],200);
        }
    }
}

