<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class PushTopic implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $title;
    protected $body;
    protected $topic;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($title, $body, $topic)
    {
        $this->title = $title;
        $this->body = $body;
        $this->topic = $topic;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->PushNotify($this->title, $this->body, $this->topic);
    }

    static public function PushNotify($title, $body, $topic)
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
        $data->collapse_key = "type_a";
        $data->to = '/topics/' . $topic;


        $headers = array(
            'Authorization: key=' . app('setting_main')->api_firebase,
            'Content-Type: application/json'
        );
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_exec($ch);
        curl_close($ch);
    }
}
