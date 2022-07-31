<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\FinishContractMail;
use Illuminate\Support\Facades\Mail;

class FinishContract implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $tries = 2;
    
    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $office_name;
    protected $corp_id;
    protected $mail;
    protected $password;

    public function __construct($office_name,$corp_id,$mail,$password)
    {
        //
        $this->office_name = $office_name;
        $this->mail = $mail;
        $this->password = $password;
        $this->corp_id = $corp_id;
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
            new FinishContractMail(  
                $this->office_name,              
                $this->corp_id,
                $this->mail,
                $this->password
            )   
        );
    }
}
