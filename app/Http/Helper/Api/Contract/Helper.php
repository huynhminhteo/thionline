<?php

namespace App\Http\Helper\Api\Contract;

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
use App\Jobs\SendMail;
use Dompdf\Dompdf;
use Dompdf\Options;

class Helper extends HelperBase
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct(){
        parent::__construct();
    }

    public function apiGetContractCompany($request){
        try{
            $user = $this->getUser();
            if(!in_array($user->role, config('constant.login_admin'))){
                return $this->JsonExportAPI(403, config('constant.msg_permission_denied'));
            }  
            $company = Model\MCompany::whereId($user->company_id)->with('tContracts.mPlan')
            ->whereIn('status',[1,2])
            ->first();
            if ($company)
            $company = $company->makeHidden([
                'insert_user',
                'id',
                'update_user',
                'update_at',
                'insert_at',
                'corp_id',
                'status',
                'updated_at',
                'created_at',
                'contract_date'
            ]);
            return self::JsonExportApi(200, config('constant.msg_200'), $company->tContracts ? $company->tContracts->mPlan : []);
        }catch (\Exception $e) {
            $this->__writeLog500($request->ip(), $request->method(), $request->path(), $e);
            return $this->JsonExportAPI(500, config('constant.msg_500'));
        }
    }

    public function apiGetAllPlan($request){
        try{
            $user = $this->getUser();
            if(!in_array($user->role, [1,2,3,4])){
                return $this->JsonExportAPI(403, config('constant.msg_permission_denied'));
            }
            $data_return = [];
            $plans = Model\MPlan::whereStatus(1)->get();
            foreach($plans as $value){
                if(isset($user->company) && $user->company->tContracts && $user->company->tContracts->is_trial == 1){
                    $value['amount'] = 0;
                }
            }
            return self::JsonExportApi(200, config('constant.msg_200'), $plans);
        }catch (\Exception $e) {
            $this->__writeLog500($request->ip(), $request->method(), $request->path(), $e);
            return $this->JsonExportAPI(500, config('constant.msg_500'));
        }
    }

    public function apiGetAllContract($request){
        try{
            $user = $this->getUser();
            if(!in_array($user->role, config('constant.login_operator'))){
                return $this->JsonExportAPI(403, config('constant.msg_permission_denied'));
            }

            $company = Model\TContract::distinct()->select('company_id')->get();
            $id_contract = [];
            foreach($company as $v) {
                $contract = Model\TContract::select('id')
                    ->where('company_id', $v->company_id)
                    ->orderBy('contract_year', 'desc')
                    ->orderBy('contract_month', 'desc')
                    ->first();
                $id_contract[] = $contract->id;
            }

            $contract = Model\TContract::with(['mCompany', 'mPlan'])
                ->whereIn('id', $id_contract)
                ->orderBy('contract_year', 'desc')
                ->orderBy('contract_month')
                ->orderBy('status');

            if($request->has('filter_plan') && !empty($request->filter_plan)){
                $contract = $contract->wherePlanId($request->filter_plan);
            }

            if(($request->has('filter_payment') && !empty($request->filter_payment) && $request->filter_payment == "pay")){
                if(($request->has('filter_status') && !empty($request->filter_status) && $request->filter_status == "under")){
                    $contract = $contract->whereStatus(1);
                } else if($request->has('filter_status') && !empty($request->filter_status) && $request->filter_status == "cancel"){
                    $contract = $contract->whereStatus(2);
                } else {
                    $contract = $contract->whereIn('status', [1,2]);
                }
            } else if($request->has('filter_payment') && !empty($request->filter_payment) && $request->filter_payment == "nopay"){
                if(($request->has('filter_status') && !empty($request->filter_status) && $request->filter_status == "under")){
                    $contract = $contract->whereStatus(0);
                } else if($request->has('filter_status') && !empty($request->filter_status) && $request->filter_status == "cancel"){
                    $contract = $contract->whereStatus(3);
                } else {
                    $contract = $contract->whereIn('status', [0,3]);
                }
            }

            if(($request->has('filter_status') && !empty($request->filter_status) && $request->filter_status == "under")){
                if(($request->has('filter_payment') && !empty($request->filter_payment) && $request->filter_payment == "pay")){
                    $contract = $contract->whereStatus(1);
                } else if($request->has('filter_payment') && !empty($request->filter_payment) && $request->filter_payment == "nopay"){
                    $contract = $contract->whereStatus(0);
                } else {
                    $contract = $contract->whereIn('status', [0,1]);
                }
            } else if($request->has('filter_status') && !empty($request->filter_status) && $request->filter_status == "cancel"){
                if(($request->has('filter_payment') && !empty($request->filter_payment) && $request->filter_payment == "pay")){
                    $contract = $contract->whereStatus(2);
                } else if($request->has('filter_payment') && !empty($request->filter_payment) && $request->filter_payment == "nopay"){
                    $contract = $contract->whereStatus(3);
                } else {
                    $contract = $contract->whereIn('status', [2,3]);
                }
            }

            if($request->has('filter_text') && !empty($request->filter_text)){
                $keywork = $request->filter_text;
                $contract = $contract->whereHas('mCompany', function($query) use ($keywork) {
                    $query->where('name','like','%'.$keywork.'%')
                        ->orWhere('name_kana','like','%'.$keywork.'%')
                        ->orWhere('office_name','like','%'.$keywork.'%')
                        ->orWhere('office_name_kana','like','%'.$keywork.'%')
                        ->orWhere('corp_id','like','%'.$keywork.'%');
                });
            }

            return Datatables::of($contract)
            ->addColumn('status_charge',function($v){
                if($v->is_trial == 1){
                    return 'トライアル';
                }else if(in_array($v->status,[1,2])){
                    return $v->contract_month.'月 入金済み';
                }else{
                    return $v->contract_month.'月 未入金';
                }
            })
            ->addColumn('status_contract',function($v){
                if(in_array($v->status,[0,1])){
                    return  '契約中';
                }else{
                    return  '解約';
                }
            })
            ->make(true);
        }catch (\Exception $e) {
            $this->__writeLog500($request->ip(), $request->method(), $request->path(), $e);
            return $this->JsonExportAPI(500, config('constant.msg_500'));
        }
    }

    public function apiGetDetailCompany($request){
        try{
            $user = $this->getUser();
            if(!in_array($user->role, config('constant.login_operator'))){
                return $this->JsonExportAPI(403, config('constant.msg_permission_denied'));
            }

            $company = Model\MCompany::find($request->companyId);

            return self::JsonExportApi(200, config('constant.msg_200'), $company);
        }catch (\Exception $e) {
            $this->__writeLog500($request->ip(), $request->method(), $request->path(), $e);
            return $this->JsonExportAPI(500, config('constant.msg_500'));
        }
    }

    public function apiGetDetailAllContract($request){
        try{
            $user = $this->getUser();
            if(!in_array($user->role, config('constant.login_operator'))){
                return $this->JsonExportAPI(403, config('constant.msg_permission_denied'));
            }

            $contract = Model\TContract::with(['mCompany', 'mPlan'])
            ->whereCompanyId($request->companyId)
            ->orderBy('contract_year', 'desc')
            ->orderBy('status')
            ->get();

            return self::JsonExportApi(200, config('constant.msg_200'), $contract);
        }catch (\Exception $e) {
            $this->__writeLog500($request->ip(), $request->method(), $request->path(), $e);
            return $this->JsonExportAPI(500, config('constant.msg_500'));
        }
    }

    public function apiUpdateStatusCompany($request){
        try{
            $rules = array(
                'companyId' => 'required',
                'type'      => 'required'
            );
    
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return $this->JsonExportAPI(403, $validator->errors()->first());
            }

            $user = $this->getUser();
            if(!in_array($user->role, config('constant.login_operator'))){
                return $this->JsonExportAPI(403, config('constant.msg_permission_denied'));
            }

            DB::beginTransaction();
          
            if($request->type == "un_use") {
                $company = Model\MCompany::whereId($request->companyId)->update([
                    'status' => 0
                ]);

                // Attack Expire full token of Company
                $url = config('constant.admin_url').'/api/blacklist/token_company/v1';
            
                $data_db = Model\MDatabaseCompany::whereCompanyId($request->companyId)->first();
                $data = [
                    'company_id'    =>  $request->companyId,
                    'db'            =>  Crypt::encryptString(json_encode($data_db,true))
                ];
                $response = Http::withOptions(['verify' => false])->post($url,$data);
                $data_callback = $response->json();
                if($response->status() !== 200){
                    return $this->JsonExportAPI(500, config('constant.msg_500'));
                }

                DB::commit();
                return self::JsonExportApi(200, '利用停止しました');
            } else {
                $company = Model\MCompany::whereId($request->companyId)->update([
                    'status' => 1
                ]);

                DB::commit();
                return self::JsonExportApi(200, '利用再開しました');
            }
        }catch (\Exception $e) {
            DB::rollBack();
            $this->__writeLog500($request->ip(), $request->method(), $request->path(), $e);
            return $this->JsonExportAPI(500, config('constant.msg_500'));
        }
    }

    public function apiGetSummaryContract($request){
        try{
            $user = $this->getUser();
            if(!in_array($user->role, config('constant.login_operator'))){
                return $this->JsonExportAPI(403, config('constant.msg_permission_denied'));
            }

            $company = Model\TContract::distinct()->select('company_id')->get();
            $id_contract = [];
            foreach($company as $v) {
                $contract = Model\TContract::select('id')
                    ->where('company_id', $v->company_id)
                    ->orderBy('contract_year', 'desc')
                    ->orderBy('contract_month', 'desc')
                    ->first();
                $id_contract[] = $contract->id;
            }

            $data['total'] = Model\TContract::whereIn('id', $id_contract)->whereIn('status', [0, 1])->count();
            $data['summary'] = Model\TContract::select('plan_id', DB::raw('count(*) as total'))->with('mPlan')
                ->whereIn('id', $id_contract)
                ->whereIn('status', [0, 1])
                ->groupBy('plan_id')
                ->get();

            return self::JsonExportApi(200, config('constant.msg_200'), $data);
        }catch (\Exception $e) {
            $this->__writeLog500($request->ip(), $request->method(), $request->path(), $e);
            return $this->JsonExportAPI(500, config('constant.msg_500'));
        }
    }

    
    public function apiCancelContractCompany($request){
        try{
            $user = $this->getUser();
   
            DB::beginTransaction();
            if(in_array($user->company->status,[1,2])){
                // call API cancel Contract external
                // /api/withdraw/{version}
                $url = config('constant.withdraw_url');
                $data_post = [
                    'customer_id' => $user->company->tContracts->charge_client_id,
                    'settlement_id' => $user->company->tContracts->regular_charge_id
                ];
                $response = Http::withBasicAuth(env('API_BASIC_AUTH_USERNAME'),env('API_BASIC_AUTH_PASS'))->withOptions([
                    'verify' => false
                ])->post($url,$data_post);

                $data_callback = $response->json();
                if($data_callback['result'] !== 0){
                    return $this->JsonExportAPI(403, $data_callback['err_msg']);
                }

                $data = [
                    'insert_user' => $user->id,
                    'update_user'   => $user->id,
                    'company_id'    => $user->company->id,
                    'plan_id'       => $user->company->tContracts->mPlan->id,
                    'status'        => 2,
                    'charge_client_id' => $user->company->tContracts->charge_client_id,
                    'regular_charge_id' =>  $user->company->tContracts->regular_charge_id,
                    'action_status' => 0
                ];
                Model\TCompanyTransaction::create($data);
                
                $check_company = Model\TCompanyTransaction::whereCompanyId($user->company->id)->first();
                if($check_company){
                    $update_cancel_contract_date = Model\MCompany::whereId($user->company->id)->update(['cancel_contract_date' => Carbon::now()]);
                }
            }
            DB::commit();
            return self::JsonExportApi(200, config('constant.msg_200'));
        }catch (\Exception $e) {
            DB::rollback();
            $this->__writeLog500($request->ip(), $request->method(), $request->path(), $e);
            return $this->JsonExportAPI(500, config('constant.msg_500'));
        }
    }

    public function apiContractChangePlan($request){
        try{
            $user = $this->getUser();
            $plan_type = [
                1 => 'lite',
                2 => 'standard',
                3 => 'premium'
            ];

            // $plan_type_trial = [
            //     1 => 'lite_trial',
            //     2 => 'standard_trial',
            //     3 => 'premium_trial'
            // ];

            // if($user->company->tContracts->is_trial == 1){
                $plan_name = $plan_type[$request->plan_type];
            // }else{
            //     $plan_name = $plan_type_trial[$request->plan_type];
            // }

            // call API cancel Contract external
            // /api/withdraw/{version}
            $url = config('constant.change_next_plan_url');
            $data_post = [
                'customer_id' => $user->company->tContracts->charge_client_id,
                'settlement_id' => $user->company->tContracts->regular_charge_id,
                'next_plan_type' => $plan_name
            ];
          
            $response = Http::withBasicAuth(env('API_BASIC_AUTH_USERNAME'),env('API_BASIC_AUTH_PASS'))->withOptions([
                'verify' => false
            ])->post($url,$data_post);
            $data_callback = $response->json();
            if($data_callback['result'] !== 0){
                return $this->JsonExportAPI(403, $data_callback['err_msg']);
            }

            $user->company->tContracts->update([
                'plan_id' => $request->plan_type
            ]);
            $comp_trans = Model\TCompanyTransaction::whereCompanyId($user->company->id)->whereActionStatus(2)->first();
            if ($comp_trans) {
                $data = [
                    'insert_user'       => $user->id,
                    'update_user'       => $user->id,
                    'insert_at'         => Carbon::now(),
                    'update_at'         => Carbon::now(),
                    'plan_id'           => $request->plan_type,
                    'charge_client_id'  => $user->company->tContracts->charge_client_id ?? '',
                    'regular_charge_id' => $user->company->tContracts->regular_charge_id ?? '',
                ];
                $comp_trans->update($data);
            } else {
                $data = [
                    'insert_user'       => $user->id,
                    'update_user'       => $user->id,
                    'company_id'        => $user->company->id,
                    'plan_id'           => $request->plan_type,
                    'status'            => 0,
                    'charge_client_id'  => $user->company->tContracts->charge_client_id ?? '',
                    'regular_charge_id' => $user->company->tContracts->regular_charge_id ?? '',
                    'action_status'     => 2
                ];
                Model\TCompanyTransaction::create($data);
            }
            

            return self::JsonExportApi(200, config('constant.msg_200'));
        }catch (\Exception $e) {
            DB::rollback();
            $this->__writeLog500($request->ip(), $request->method(), $request->path(), $e);
            return $this->JsonExportAPI(500, config('constant.msg_500'));
        }
    }

    public function exportBill($request) {
        try {
            $contract = Model\TContract::with(['mCompany', 'mPlan'])->find($request->id);
            $date_contract = Carbon::parse($contract->contract_year.'-'.$contract->contract_month.'-01')->format('Ym');
            $data = [
                'year' => Carbon::now()->format('Y'),
                'month' => Carbon::now()->format('m'),
                'day' => Carbon::now()->format('d'),
                'contract' => $contract,
                'company' => $contract->mCompany,
                'plan' => $contract->mPlan,
                'date_contract' => Carbon::parse($contract->contract_year.'-'.$contract->contract_month.'-01'),
                'bill_date' => Carbon::parse($contract->contract_year.'-'.$contract->contract_month.'-01')->subMonths(1)
            ];
            
            $html = view('mail.bill', $data)->render();

            $options = new Options();
            $options->setIsRemoteEnabled(true);

            $dompdf = new DOMPDF($options);
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();
            ob_end_clean();

            return $dompdf->stream();
        } catch (\Exception $e) {
            $this->__writeLog500($request->ip(), $request->method(), $request->path(), $e);
            return $this->JsonExportAPI(500, config('constant.msg_500'));
        }
    }

    public function exportReceipt($request) {
        try {
            $contract = Model\TContract::with(['mCompany', 'mPlan'])->find($request->id);
            $date_contract = Carbon::parse($contract->contract_year.'-'.$contract->contract_month.'-01')->format('Ym');
            $data = [
                'year' => Carbon::now()->format('Y'),
                'month' => Carbon::now()->format('m'),
                'day' => Carbon::now()->format('d'),
                'contract' => $contract,
                'company' => $contract->mCompany,
                'plan' => $contract->mPlan,
                'date_contract' => Carbon::parse($contract->contract_year.'-'.$contract->contract_month.'-01'),
                'bill_date' => Carbon::parse($contract->contract_year.'-'.$contract->contract_month.'-01')->subMonths(1)
            ];
            
            $html = view('mail.receipt', $data)->render();

            $options = new Options();
            $options->setIsRemoteEnabled(true);

            $dompdf = new DOMPDF($options);
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();
            ob_end_clean();

            return $dompdf->stream();
        } catch (\Exception $e) {
            $this->__writeLog500($request->ip(), $request->method(), $request->path(), $e);
            return $this->JsonExportAPI(500, config('constant.msg_500'));
        }
    }
}