<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPassword extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $mail;
    protected $password;
    protected $account_manager_name;

    public function __construct($mail,$password,$account_manager_name)
    {
        $this->password = $password;
        $this->mail = $mail;
        $this->account_manager_name = $account_manager_name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('info@med-hovit.com')
        ->subject("【HOVIT管理システム】パスワード再発行完了です")
        ->view('mail.reset_password')
        ->with([
            'mail'                  => $this->mail,
            'password'              => $this->password,
            'account_manager_name'  => $this->account_manager_name
        ]);
    }
}
