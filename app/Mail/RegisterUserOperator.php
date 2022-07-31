<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RegisterUserOperator extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    protected $mail;
    protected $password;
    protected $operator_user_current_name;

    public function __construct($mail,$password,$operator_user_current_name)
    {
        $this->password = $password;
        $this->mail = $mail;
        $this->operator_user_current_name = $operator_user_current_name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('info@med-hovit.com')
        ->subject("【HOVIT運営システム】運営ユーザー登録完了")
        ->view('mail.register_new_operator_user')
        ->with([
            'mail'                          => $this->mail,
            'password'                      => $this->password,
            'operator_user_current_name'    => $this->operator_user_current_name
        ]);
    }
}
