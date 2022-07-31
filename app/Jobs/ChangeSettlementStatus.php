<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\CancelContractMail;
use App\Mail\NoPayMail;
use App\Mail\PayMail;
use Illuminate\Support\Facades\Mail;
use App\Model;
use Carbon\Carbon;

class ChangeSettlementStatus implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $tries = 2;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $mail;
    protected $company_id;
    protected $type;
    protected $billing_deadline;
    protected $check_next_plan;

    public function __construct($mail,$company_id,$type = 'pay',$billing_deadline, $check_next_plan = null)
    {
        //
        $this->mail = $mail;
        $this->company_id = $company_id;
        $this->type = $type;
        $this->billing_deadline = $billing_deadline;
        $this->check_next_plan = $check_next_plan;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        $company = Model\MCompany::whereId($this->company_id)->first();
        $office_name = $company->office_name;

        if($this->type == 'cancel'){
            Mail::to($this->mail)->send(
                new CancelContractMail(    
                    $office_name    
                )   
            );
        }else if($this->type == 'no_pay'){
            $plan_name = $company->tContracts->mPlan->name;
            $plan_date = Carbon::parse($company->tContracts->contract_year. '-'.$company->tContracts->contract_month)->startOfMonth()->format('Y年m月d日')
            .' ~ '.
            Carbon::parse($company->tContracts->contract_year. '-'.$company->tContracts->contract_month)->endOfMonth()->format('Y年m月d日');
            Mail::to($this->mail)->send(
                new NoPayMail(    
                    $office_name,  
                    $plan_name, 
                    $plan_date,
                    $this->billing_deadline        
                )   
            );
        }else if($this->type == 'pay_limit'){
            $plan_name = Model\MPlan::find($this->check_next_plan);
            $plan_name = $plan_name->name;
            $plan_date = Carbon::parse($company->tContracts->contract_year. '-'.$company->tContracts->contract_month)->startOfMonth()->format('Y年m月d日')
            .' ~ '.
            Carbon::parse($company->tContracts->contract_year. '-'.$company->tContracts->contract_month)->endOfMonth()->format('Y年m月d日');
            // pay money
            Mail::to($this->mail)->send(
                new PayMail(    
                    $office_name,  
                    $plan_name, 
                    $plan_date,
                    $this->billing_deadline 
                )   
            );
        }else{
            $plan_name = Model\MPlan::find($this->check_next_plan);
            $plan_name = $plan_name->name;
            $plan_date = Carbon::parse($company->tContracts->contract_year. '-'.$company->tContracts->contract_month)->addMonths(1)->startOfMonth()->format('Y年m月d日')
            .' ~ '.
            Carbon::parse($company->tContracts->contract_year. '-'.$company->tContracts->contract_month)->addMonths(1)->endOfMonth()->format('Y年m月d日');
            // pay money
            Mail::to($this->mail)->send(
                new PayMail(    
                    $office_name,  
                    $plan_name, 
                    $plan_date,
                    $this->billing_deadline 
                )   
            );
        }
    }
}
