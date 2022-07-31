<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FinishContractMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $corp_id;
    protected $mail;
    protected $password;
    protected $office_name;

    public function __construct($office_name,$corp_id,$mail,$password)
    {
        //
        $this->office_name = $office_name;
        $this->mail = $mail;
        $this->password = $password;
        $this->corp_id = $corp_id;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('info@med-hovit.com')
        ->subject("【HOVIT】ご契約完了")
        ->view('mail.finish_contract')
        ->with([
            'office_name'   => $this->office_name,
            'mail'          => $this->mail,
            'password'      => $this->password,
            'corp_id'       => $this->corp_id
        ]);
    }
}
