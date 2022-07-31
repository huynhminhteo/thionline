<?php

namespace App\Http\Controllers\Admin\Test;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Model;

class TestController extends Controller
{
    protected $instance;
    protected $lang;

    public function __construct()
    {
        $this->instance = $this->instance(\App\Http\Helper\Admin\Helper::class);
    }

    public function get_list_test(){
        $user = $this->getInfoUserCookie();
        if (in_array($user['role'], [2])) {
            return view('theme.web.page.test.index', [
                'page_title' => 'Danh sách đề thi'
            ]);
        }
    }

    public function get_list_group($id_test){
        $user = $this->getInfoUserCookie();
        if (in_array($user['role'], [2])) {
            $code_test = Model\Test::find($id_test)->code;
            return view('theme.web.page.group.index', [
                'page_title' => 'Danh sách các phần thi của đề thi '.$code_test,
                'test_id' => $id_test
            ]);
        }
    }
}
