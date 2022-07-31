<?php

namespace App\Http\Controllers\Admin\GetAudio;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Storage;

class GetAudioController extends Controller
{
    protected $instance;
    protected $lang;

    public function __construct()
    {
        $this->instance = $this->instance(\App\Http\Helper\Admin\Helper::class);
    }

    public function get_audio() {
        $list = Storage::disk('public_audio')->listContents();

        $users = [];
        foreach($list as $audio) {
            $split = explode(" - ", $audio['filename']);
            $users[$split[0]]["dethi"] = $split[1];
            $users[$split[0]]["phanthi"][$split[2]][] = [
                "cau" => $split[3],
                "basename" => $audio['basename']
            ];
        }

        return view('theme.web.page.get_audio.index', [
            'page_title' => 'Danh sách bài làm',
            'users' => $users
        ]);
    }
}
