<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\ChangeCardMail;
use Illuminate\Support\Facades\Mail;

class ChangeCard implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $tries = 2;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $office_name;
    protected $plan_name;
    protected $contract_date;
    protected $transaction_date;
    protected $mail;

    public function __construct($mail,$office_name,$plan_name,$contract_date,$transaction_date)
    {
        //
        $this->office_name = $office_name;
        $this->mail = $mail;
        $this->plan_name = $plan_name;
        $this->contract_date = $contract_date;
        $this->transaction_date = $transaction_date;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        Mail::to($this->mail)->send(
            new ChangeCardMail(    
                $this->office_name,            
                $this->plan_name,
                $this->contract_date,
                $this->transaction_date
            )   
        );
    }
}
