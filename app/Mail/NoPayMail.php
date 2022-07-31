<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NoPayMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $office_name;
    protected $plan_name;
    protected $plan_date;
    protected $transaction_date;

    public function __construct($office_name,$plan_name,$plan_date,$transaction_date)
    {
        $this->office_name = $office_name;
        $this->plan_name = $plan_name;
        $this->plan_date = $plan_date;
        $this->transaction_date = $transaction_date;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('info@med-hovit.com')
        ->subject("【HOVIT】未入金のお知らせ")
        ->view('mail.not_pay_money')
        ->with([
            'office_name'       => $this->office_name,
            'plan_name'         => $this->plan_name,
            'plan_date'         => $this->plan_date,
            'transaction_date'  => $this->transaction_date
        ]);
    }
}
