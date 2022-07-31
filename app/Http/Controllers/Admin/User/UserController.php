<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class UserController extends Controller
{
    protected $instance;
    protected $lang;

    public function __construct()
    {
        $this->instance = $this->instance(\App\Http\Helper\Admin\Helper::class);
    }

    public function user_get_list(){
        $user = $this->getInfoUserCookie();
        if (in_array($user['role'], [1])) {
            return view('theme.web.page.user.index', [
                'page_title' => '管理ユーザー一覧'
            ]);
        } else {
            // 
        }
    }
}
