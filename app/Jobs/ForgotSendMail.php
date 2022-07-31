<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\ForgotPassword;
use Illuminate\Support\Facades\Mail;

class ForgotSendMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $tries = 2;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $mail;
    protected $link;

    public function __construct($mail,$link)
    {
        //
        $this->mail = $mail;
        $this->link = $link;
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
            new ForgotPassword(                
                $this->link
            )   
        );
    }
}
