<?php

namespace App\Http\Controllers\Admin\Utils;

use App\Http\Controllers\Controller;
use App\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use GrahamCampbell\Throttle\Facades\Throttle;
use Hash;

class AjaxController extends Controller
{
    protected $instance;

    public function __construct()
    {
        $this->instance = $this->instance(\App\Http\Helper\Admin\Utils\Helper::class);
    }

    public function admin_change_password(Request $request)
    {
        $rules = array(
            'oldpass' => 'required|min:1|max:128',
            'newpass' => 'required|min:1|max:128|confirmed'
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return $this->JsonExport(403, __('app.error_403'));
        } else {
            try {
                DB::beginTransaction();
                $user = Model\MUser::find(Auth::user()->id);
                if (!$user) {
                    DB::rollback();
                    return $this->JsonExport(403, __('app.error_403'));
                }
                if (!Hash::check($request->oldpass, $user->password)) {
                    DB::rollback();
                    return $this->JsonExport(403, __('app.wrong_password'));
                }

                $user->update([
                    'password' => Hash::make($request->newpass),
                    'last_update_password' => Carbon::now()->format('Y-m-d H:i:s.v'),
                    "updated_at" => Carbon::now()->format('Y-m-d H:i:s.v'),
                ]);

                if (!$user) {
                    DB::rollback();
                    return $this->JsonExport(403, __('app.update_fail'));
                }

                DB::commit();
                return $this->JsonExport(200, __('app.success'));

            } catch (\Exception $e) {
                $this->__writeLog500($request->ip(), $request->method(), $request->path(), $e);
                return $this->JsonExportAPI(500, config('constant.msg_500'));
            }
        }
    }

    public function admin_login_ajax(Request $request)
    {
        $rules = array(
            'username' => 'required|min:9|max:12|phonevn',
            'password' => 'required|min:1|max:128',
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return $this->JsonExport(403, __('app.error_403'));
        } else {
            $throttler = Throttle::get($request, app('setting_main')->limit_login, app('setting_main')->limit_login_waiting);
            try {
                if (!$throttler->check()) {
                    return $this->JsonExport(401, __('app.login_limit', ['count' => app('setting_main')->limit_login, 'time' => app('setting_main')->limit_login_waiting]));
                }

                $credentials = [
                    'phone' => $request->username,
                    'password' => $request->password,
                    'status' => 1
                ];
                if (\Auth::attempt($credentials)) {
                    if (in_array("Delivery", $this->getRoleUser())) {
                        $throttler->hit();
                        if (Auth::user()) {
                            Auth::logout();
                        }
                        return $this->JsonExport(403, __('app.wrong_password'));
                    }
                    return $this->JsonExport(200, __('app.login_success'));
                } else {
                    $throttler->hit();
                    return $this->JsonExport(403, __('app.wrong_password'));
                }

            } catch (\Exception $e) {
                $throttler->hit();
                $this->__writeLog500($request->ip(), $request->method(), $request->path(), $e);
                return $this->JsonExportAPI(500, config('constant.msg_500'));
            }
        }
    }

    public function admin_logout_ajax(Request $request)
    {
        try {
            if (Auth::user()) {
                Auth::logout();
            }
            session()->flush();
            return redirect()->route('admin.page.login');
        } catch (\Exception $e) {
            return redirect()->route('admin.page.login');
        }
    }
    
}
