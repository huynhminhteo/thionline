<?php

namespace App\Http\Controllers\Admin\Thankyou;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class ThankyouController extends Controller
{
    protected $instance;
    protected $lang;

    public function __construct()
    {
        $this->instance = $this->instance(\App\Http\Helper\Admin\Helper::class);
    }

    public function get_thankyou() {
        return view('theme.web.page.dashboard.thankyou.index', [
            'page_title' => 'Thank you',
        ]);
    }
}
