<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RegisterUserAdmin extends Mailable
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
        ->subject("【HOVIT】管理システム】管理ユーザー登録完了")
        ->view('mail.register_new_admin_user')
        ->with([
            'mail'                  => $this->mail,
            'password'              => $this->password,
            'account_manager_name'  => $this->account_manager_name
        ]);
    }
}
