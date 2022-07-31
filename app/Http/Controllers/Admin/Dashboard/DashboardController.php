<?php

namespace App\Http\Controllers\Admin\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Model;
use Carbon\Carbon;

class DashboardController extends Controller
{
    protected $instance;
    protected $lang;

    public function __construct()
    {
        $this->instance = $this->instance(\App\Http\Helper\Admin\Helper::class);
    }

    public function get_dashboard() {
        $user = $this->getInfoUserCookie();
        $check_core = Model\Core::whereDate('date', Carbon::parse(Carbon::now())->format('Y-m-d'))->where('status', 0)->first();
        // if ($user->test_id) { // redirect to exam screen 3
        //     return 4;
        //     return view('theme.web.page.core.index', [
        //         'page_title' => 'exem time Danh sách đợt thi'
        //     ]);
        // } else {
            if ($check_core && Carbon::parse($check_core->date) > Carbon::now()) { // waiting time 1
                // return 3;
                return view('theme.web.page.dashboard.waiting.index', [
                    'page_title' => 'Waiting time',
                    'time_start' => Carbon::parse($check_core->date)->format('Y-m-d H:i:s')
                ]);
            } else if ($check_core && Carbon::parse($check_core->date) <= Carbon::now()) { // redirect random screen 2
                // return 2;
                return redirect()->route('operator.random');
            } else { // dashboard 0
                // return 1;
                return view('theme.web.page.dashboard.index', [
                    'page_title' => 'Dashborad bla bla'
                ]);
            }
        // }
    }
}
