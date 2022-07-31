<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewUserMail;
use App\Mail\ForgotPassword;
use App\Mail\RegisterUserAdmin;
use App\Mail\RegisterUserOperator;
use App\Mail\ResetPassword;

class SendMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $mail_to;
    protected $mail_password;
    protected $mail_type;
    protected $content;
    protected $account_manager_name;
    protected $operator_user_current_name;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($mail_to, $mail_password, $mail_type = "newuser", $content = '', $account_manager_name = '', $operator_user_current_name = '')
    {
        $this->mail_to = $mail_to;
        $this->mail_password = $mail_password;
        $this->mail_type = $mail_type;
        $this->content = $content;
        $this->account_manager_name = $account_manager_name;
        $this->operator_user_current_name = $operator_user_current_name;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if ($this->mail_type == 'newuser') {
            Mail::to($this->mail_to)->send(
                new NewUserMail(
                    $this->mail_to,
                    $this->mail_password,
                    $this->account_manager_name
                )
            );
        } else if ($this->mail_type == 'reset') {
            Mail::to($this->mail_to)->send(
                new ResetPassword(
                    $this->mail_to,
                    $this->mail_password,
                    $this->account_manager_name
                )
            );
        } else if ($this->mail_type == 'newuseradmin') {
            Mail::to($this->mail_to)->send(
                new RegisterUserAdmin(
                    $this->mail_to,
                    $this->mail_password,
                    $this->account_manager_name
                )
            );
        } else if ($this->mail_type == 'forgot') {
            Mail::to($this->mail_to)->send(
                new ForgotPassword(
                    $this->mail_password
                )
            );
        } else if ($this->mail_type == 'new_user_operator') {
            Mail::to($this->mail_to)->send(
                new RegisterUserOperator(
                    $this->mail_to,
                    $this->mail_password,
                    $this->operator_user_current_name
                )
            );
        }

    }
}
