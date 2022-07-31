<?php

namespace App\Http\Controllers\Admin\Core;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Model;

class CoreController extends Controller
{
    protected $instance;
    protected $lang;

    public function __construct()
    {
        $this->instance = $this->instance(\App\Http\Helper\Admin\Helper::class);
    }

    public function get_list_core(){
        $user = $this->getInfoUserCookie();
        if (in_array($user['role'], [2])) {
            return view('theme.web.page.core.index', [
                'page_title' => 'Danh sách đợt thi'
            ]);
        }
    }

    public function get_list_test($id_core){
        $user = $this->getInfoUserCookie();
        if (in_array($user['role'], [2])) {
            $name_core = Model\Core::find($id_core)->name;
            return view('theme.web.page.test.index', [
                'page_title' => 'Danh sách đề thi '.$name_core,
                'core_id' => $id_core
            ]);
        }
    }
}
