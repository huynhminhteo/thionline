<?php

namespace App\Http\Controllers\Admin\Examination;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Model;
use Carbon\Carbon;

class ExaminationController extends Controller
{
    protected $instance;
    protected $lang;

    public function __construct()
    {
        $this->instance = $this->instance(\App\Http\Helper\Admin\Helper::class);
    }

    public function get_examination($id_test, $stt_group){
        // $user = $this->getInfoUserCookie();
        // if (in_array($user['role'], [2])) {
            $core_id = Model\Test::find($id_test)->core_id;
            $core = Model\Core::find($core_id);
            $group = Model\Group::where('test_id', $id_test)->where('stt', $stt_group)->first();
            $next_group = Model\Group::where('test_id', $id_test)->where('stt', '>', $stt_group)->orderBy('stt')->first();
            $questions = Model\Question::where('group_id', $group->id)->get();
            return view('theme.web.page.examination.index', [
                'page_title'    => 'パート'.$group->stt.'　'.$group->name,
                'time_start'    => $core->date,
                'time'          => $group->time,
                'questions'     => $questions,
                'test'          => $id_test,
                'group'         => $stt_group,
                'next_group'    => $next_group->stt ?? 0
            ]);
        // }
    }
}
