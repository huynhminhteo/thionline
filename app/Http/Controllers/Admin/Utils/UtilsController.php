<?php

namespace App\Http\Controllers\Admin\Utils;

use App\Http\Controllers\Controller;
use App\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Intervention\Image\ImageManagerStatic as Image;
use App\Jobs\Otp;
use Hash;

class UtilsController extends Controller
{
    protected $instance;
    protected $lang;

    public function __construct()
    {
        $this->instance = $this->instance(\App\Http\Helper\Admin\Helper::class);
    }

    public function admin_login(Request $request)
    {
        try {
            if (Auth::check()) {
                return redirect()->route(app('setting_main')->default_page);
            } else {
                return view('theme.web.page.login.index');
            }
        } catch (\Exception $e) {
            return redirect()->route('admin.page.login');
        }
    }
}