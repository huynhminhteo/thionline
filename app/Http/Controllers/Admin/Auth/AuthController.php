<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Artisan;
use App\Model;
use Cookie;
use Storage;

class AuthController extends Controller
{
    //
    protected $instance;

    public function __construct()
    {
        $this->instance = $this->instance(\App\Http\Helper\Admin\Auth\Helper::class);
    }

    public function login(){
        try{         
            $token = Cookie::get('_token_mainte');
            if($token && Auth::check()){
                return redirect()->route('admin.page.index');
            }else{
                return view('theme.web.page.auth.login');
            }
        }catch(\Exception $e){
            return redirect()->route('admin.page.login');
        }
    }

    public function index(Request $request){
        return redirect()->route('operator.dashboard');
    }

    public function logout(){
        try{
            $token = Cookie::get('_token_mainte');
            $this->blacklist($token);
            Cookie::queue(Cookie::forget('_token_mainte'));
         
            return redirect()->route('admin.page.login');
        }catch(\Exception $e){
            return redirect()->route('admin.page.login');
        }
    }

    public function forgot()
    {
        try {
           return view('theme.web.page.auth.forgot');
        } catch (\Exception $e) {
            return redirect()->route('admin.page.login');
        }
    }

    public function forgot_password_admin($token)
    {
        try {
            $checkToken = $this->instance->checkLink($token);
            if ($checkToken === false) {
                return view('welcome', [
                    'messages' => 'パスワードリセットリンクの有効期限が切れています'
                ]);
            }
            return view('theme.web.page.auth.forgot_change_password', [
                'user' => $checkToken,
                'token' => $token
            ]);
        } catch (\Exception $e) {
            return view('welcome', [
                'messages' => 'パスワードリセットリンクの有効期限が切れています'
            ]);
        }
    }

    public function batch_monthly(){
        Artisan::call('monthly:run');
        return 'Xong rồi anh Hải ạ!';

    }

    public function change_password(Request $request){
        try {
            return view('theme.web.page.auth.change_password');
        } catch (\Exception $e) {
            return view('errors.403');
        }
    }

    public function blacklist($token)
    {
        try {
            $check = Storage::disk('blacklist')->exists(md5($token));
            if(!$check) {
                Storage::disk('blacklist')->put(md5($token), 'Blocked');
            }
        } catch (\Exception $e) {
            return;
        }
    }
}
