<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Crypt;

class BatchMonthly extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'monthly:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run monthly batch to apply plan or contract company';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
       
        if(Carbon::now()->format('j') == 1){
            $user_mainte = Model\MUser::whereRole(1)->first();
            $company_status = Model\TCompanyTransaction::whereActionStatus(0)
            ->get();
            $company_transaction = [];
            DB::beginTransaction();
            foreach($company_status as $value){
                $save = true;
                $company = $value->mCompany;
                if($company){
                    array_push($company_transaction,$value->company_id);
                    if($company->status != 0){
                         // Create Contract new month
                         $data = [
                            'insert_user'       => $user_mainte->id,
                            'update_user'       => $user_mainte->id,
                            'company_id'        => $company->id,
                            'contract_year'     => Carbon::parse($value->insert_at)->startOfMonth()->addMonths(1)->format('Y'),
                            'contract_month'    => Carbon::parse($value->insert_at)->startOfMonth()->addMonths(1)->format('n'),
                            'plan_id'           => $value->plan_id,
                            'amount'            => $value->mPlan->amount,
                            'charge_client_id'  => $value->charge_client_id,
                            'regular_charge_id' => $value->regular_charge_id
                        ];

                                    
                        $data_contract_month_past = Model\TContract::whereCompanyId($company->id)
                        ->where('contract_month',Carbon::now()->subMonths(1)->format('n'))
                        ->where('contract_year',Carbon::now()->subMonth(1)->format('Y'))
                        ->first();
                        if($data_contract_month_past){
                            if($data_contract_month_past->is_trial == 1){
                                $data['is_trial'] = 1;
                            }
                        }

                        if(in_array($value->status,[0,1])){
                            if($value->status == 0){
                                $data['status'] = 1;
                                if($company->status == 2){
                                    $company->update([
                                        'status' => 1
                                    ]);
                                }
                            }else if($value->status == 1){
                                $data['status'] = 0;
                                // limit function
                                $company->update([
                                    'status' => 2
                                ]);

                                // Attack Expire full token of Company
                                $url = config('constant.admin_url').'/api/blacklist/token_company/v1';
                            
                                $data_db = Model\MDatabaseCompany::whereCompanyId($company->id)->first();
                            
                                $data_post = [
                                    'company_id'    =>  $value->company_id,
                                    'db'            =>  Crypt::encryptString(json_encode($data_db,true))
                                ];
                                $response = Http::withOptions(['verify' => false])->post($url,$data_post);
                                $data_callback = $response->json();
                      
                                if($response->status() !== 200){
                                    $save = false;
                                }
                            }
                            // check exits contract in month present
                            $data_contract_month_present = Model\TContract::whereCompanyId($company->id)
                            ->where('contract_month',Carbon::parse($value->insert_at)->startOfMonth()->addMonths(1)->format('n'))
                            ->where('contract_year',Carbon::parse($value->insert_at)->startOfMonth()->addMonths(1)->format('Y'))
                            ->first();

                           
                            if($save){
                                if(!$data_contract_month_present){
                                    $data_contract_month_present = Model\TContract::create($data);
                                }else{
                                    Model\TContract::whereCompanyId($value->company_id)
                                    ->where('contract_month',Carbon::parse($value->insert_at)->startOfMonth()->addMonths(1)->format('n'))
                                    ->where('contract_year',Carbon::parse($value->insert_at)->startOfMonth()->addMonths(1)->format('Y'))
                                    ->update($data);
                                    $data_contract_month_present = Model\TContract::whereCompanyId($company->id)
                                    ->where('contract_month',Carbon::now()->format('n'))
                                    ->where('contract_year',Carbon::now()->format('Y'))
                                    ->first();
                                }
                            }

                            // create new contract for next month
                            $data_contract_month_next = Model\TContract::whereCompanyId($company->id)
                            ->where('contract_month',Carbon::parse($value->insert_at)->startOfMonth()->addMonths(2)->format('n'))
                            ->where('contract_year',Carbon::parse($value->insert_at)->startOfMonth()->addMonths(2)->format('Y'))
                            ->first();
                            if(!$data_contract_month_next){
                                $data = [
                                    'insert_user'       => $data_contract_month_present->insert_user,
                                    'update_user'       => $data_contract_month_present->update_user,
                                    'company_id'        => $value->company_id,
                                    'contract_year'     => Carbon::parse($value->insert_at)->startOfMonth()->addMonths(2)->format('Y'),
                                    'contract_month'    => Carbon::parse($value->insert_at)->startOfMonth()->addMonths(2)->format('n'),
                                    'plan_id'           => $data_contract_month_present->plan_id,
                                    'amount'            => $data_contract_month_present->amount,
                                    'is_trial'          => $data_contract_month_present->is_trial,
                                    'charge_client_id'  => $data_contract_month_present->charge_client_id,
                                    'regular_charge_id' => $data_contract_month_present->regular_charge_id,
                                    'status'            => 0
                                ];
    
                                Model\TContract::create($data);
                            }
                        }                       
                        if($value->status == 2){
                            // find contract in month cancel contract & update status of contract
                            $contract = Model\TContract::whereContractYear(Carbon::parse($value->insert_at)->format('Y'))
                            ->whereCompanyId($company->id)
                            ->whereContractMonth(Carbon::parse($value->insert_at)->format('n'))
                            ->whereIn('status',[0,1])
                            ->first();
                            
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
                                $contract->update($data_contract_update);
                            }

                            // Attack Expire full token of Company
                            $url = config('constant.admin_url').'/api/blacklist/token_company/v1';
                        
                            $data_db = Model\MDatabaseCompany::whereCompanyId($value->company_id)->first();
                            $data = [
                                'company_id'    =>  $value->company_id,
                                'db'            =>  Crypt::encryptString(json_encode($data_db,true))
                            ];
                            $response = Http::withOptions(['verify' => false])->post($url,$data);
                            $data_callback = $response->json();
                            if($response->status() !== 200){
                                $save = false;
                            }
                            // update company to cancel contract
                            $company->update([
                                'status' => 0
                            ]);
                            // expire token login of user of company
                        }
                    }
                }
                $value->update([
                    'action_status' => 1
                ]);
            }
          
            $company_remain = Model\MCompany::whereNotIn('id',$company_transaction)->where('status','!=',0)->get();
         
            foreach($company_remain as $value){
                $data_contract_month_present = Model\TContract::whereCompanyId($value->id)
                ->where('contract_month',Carbon::now()->format('n'))
                ->where('contract_year',Carbon::now()->format('Y'))
                ->first();
             
                if(!$data_contract_month_present){
                    $data_contract_month_past = Model\TContract::whereCompanyId($value->id)
                    ->where('contract_month',Carbon::now()->subMonths(1)->format('n'))
                    ->where('contract_year',Carbon::now()->subMonth(1)->format('Y'))
                    ->first();
                    if($data_contract_month_past){
                        $check_plan = Model\MPlan::whereId($data_contract_month_past->plan_id)->first();
                        $data = [
                            'insert_user'       => $data_contract_month_past->insert_user,
                            'update_user'       => $data_contract_month_past->update_user,
                            'company_id'        => $value->id,
                            'contract_year'     => Carbon::now()->format('Y'),
                            'contract_month'    => Carbon::now()->format('n'),
                            'plan_id'           => $data_contract_month_past->plan_id,
                            'amount'            => $check_plan->amount,
                            'is_trial'          => $data_contract_month_past->is_trial,
                            'charge_client_id'  => $data_contract_month_past->charge_client_id,
                            'regular_charge_id' => $data_contract_month_past->regular_charge_id,
                            'status'            => 0
                        ];
    
                        $data_contract_month_present = Model\TContract::create($data);
                    }
                 
                }
                
                if($data_contract_month_present){
                    $data_contract_month_next = Model\TContract::whereCompanyId($value->id)
                    ->where('contract_month',Carbon::now()->addMonths(1)->format('n'))
                    ->where('contract_year',Carbon::now()->addMonths(1)->format('Y'))
                    ->first();
                    if(!$data_contract_month_next){
                        $check_plan = Model\MPlan::whereId($data_contract_month_present->plan_id)->first();
                        $data = [
                            'insert_user'       => $data_contract_month_present->insert_user,
                            'update_user'       => $data_contract_month_present->update_user,
                            'company_id'        => $value->id,
                            'contract_year'     => Carbon::now()->addMonths(1)->format('Y'),
                            'contract_month'    => Carbon::now()->addMonths(1)->format('n'),
                            'plan_id'           => $data_contract_month_present->plan_id,
                            'amount'            => $check_plan->amount,
                            'is_trial'          => $data_contract_month_present->is_trial,
                            'charge_client_id'  => $data_contract_month_present->charge_client_id,
                            'regular_charge_id' => $data_contract_month_present->regular_charge_id,
                            'status'            => 0
                        ];
                        Model\TContract::create($data);
                        // create contract for next month
                    }
                }
            }
            DB::commit();
        }
    }
}
