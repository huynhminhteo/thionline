<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class PushNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $title;
    protected $body;
    protected $fcm_token;
    protected $opt;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($title, $body, $fcm_token = array(), $opt = array())
    {
        $this->title = $title;
        $this->body = $body;
        $this->fcm_token = $fcm_token;
        $this->opt = $opt;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->PushNotify($this->title, $this->body, $this->fcm_token, $this->opt);
    }

    static public function PushNotify($title, $body, $fcm_token = array(), $opt = array())
    {
        $data = new \stdClass();
        $data->priority = "high";
        $data->notification = new \stdClass();
        if (mb_strlen($body) > 500) {
            $body = mb_substr($body, 0, 500) . '...';
        }
        $data->notification->body = $body;
        $data->notification->title = $title;
        $data->notification->content_available = true;
        $data->notification->sound = "default";
        $data->data = new \stdClass();
        $data->data->info = $title;
        $data->data->body = $body;
        $data->data->sound = "default";
        if(count($opt) > 0) {
            $data->data->option = $opt;
        }
        $data->collapse_key = "type_a";
        if(count($fcm_token) == 0) {
            return;
        } else if(count($fcm_token) == 1) {
            $data->to = $fcm_token[0];
        } else {
            $data->registration_ids = $fcm_token;
        }

        

        $headers = array(
            'Authorization: key=' . config('constant.token_fcm'),
            'Content-Type: application/json'
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        $result = curl_exec($ch);
        curl_close($ch);
        echo json_encode($data);

        echo $result;
    }

}
