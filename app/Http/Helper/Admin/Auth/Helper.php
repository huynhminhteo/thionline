<?php

namespace App\Http\Helper\Admin\Auth;

use Illuminate\Foundation\Bus\DispatchesJobs;
use App\Http\Helper\Admin\HelperBase;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Yajra\Datatables\Datatables;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\Filter;
use Spatie\QueryBuilder\AllowedFilter;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Auth;
use Carbon\Carbon;
use App\Model;
use Storage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Crypt;
use App\Jobs\ForgotSendMailOperator;

class Helper extends HelperBase
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        parent::__construct();
    }

    public function ajaxLogin($request){
        try {
       
            $rules = [
                'mail' => 'required',
                'password' => 'required'
            ];
            $validator = Validator::make($request->all(),$rules);
            if($validator->fails()){
                return self::JsonExport(403,$validator->errors()->first());
            }

            $url = route('api.login.operator.post');
            $data = [
                'mail'      => $request->mail,
                'password'  => $request->password
            ];
            $response = Http::withOptions(['verify' => false])->post($url, $data);
            $data_callback = $response->json();
          
            if($response->status() == 200){
                $credentials = [
                    'mail' => $request->mail,
                    'password' => $request->password,
                    'role'  => [1,2]
                ];
                $token = $data_callback['data']['token'];
                if(Auth::attempt($credentials)){
                    $user = Auth::user();
                    if(!empty($user->remember_token)) {
                        $this->blacklist($user->remember_token);
                    }

                    $user->remember_token = $token;
                    $user->save();
                    $user_token = [];
                    $user_token['id'] = $user->id;

                    $cookie = cookie('_token_mainte', $token.'|'.Crypt::encryptString(json_encode($user_token)), env('JWT_TTL'));

                    return self::JsonExportWithCookie(200, config('constant.msg_200'), null, $cookie);
                }else{
                    return self::JsonExport(403, config('constant.login_wrong'));
                }
            }else{
                return self::JsonExport($response->status(),$data_callback['msg']);
            }
           
        } catch (\Exception $e) {
            $this->__writeLog500($request->ip(), $request->method(), $request->path(), $e);
            return self::JsonExport(500, config('constant.msg_500'));
        }
    }

    public function ajaxForgot($request) {
        $rules = array(
            'email' => 'required|email'
        );
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return self::JsonExport(403, $validator->errors()->first());
        } else {
            try {
                $check = Model\MUser::whereMail($request->email)
                ->whereStatus(1)
                ->whereIn('role', config('constant.login_operator'))
                ->first();
                if(!$check){
                    return self::JsonExport(403, 'メールアドレスが存在しません');
                }

                $time = time();
                $key = config('constant.XOR_KEY');
                $hash = md5($check->id . $check->mail . $time . $key);
                $token = base64_encode($check->id . '|' . $check->mail . '|' . $time . '|' . $hash);

                //send link to mail
                $link = route('admin.page.reset_link', $token);
                ForgotSendMailOperator::dispatch($check->mail, $link);

                return self::JsonExport(200, 'パスワードリセットリンクがメールアドレスに送信されましたご確認ください');
            } catch (\Exception $e) {
                $this->__writeLog500($request->ip(), $request->method(), $request->path(), $e);
                return self::JsonExport(500, config('constant.msg_500'));
            }
        }
    }

    public function checkLink($token){
        try {
            $token_decrypt = base64_decode($token);
            if (strpos($token_decrypt, '|') !== false) {
                // explodable
                $token_decrypt = explode('|', $token_decrypt);
                $personal_id = $token_decrypt[0];
                $mail = $token_decrypt[1];
                $time = $token_decrypt[2];
                $hash = $token_decrypt[3];
                $key = config('constant.XOR_KEY');
                $md5 = md5($personal_id . $mail . $time . $key);

                if (time() - $time > 24*3600) {
                    return false;
                }
               
                if ($md5 !== $hash) {
                    return false;
                }
               
                $check_user = Model\MUser::whereMail($mail)
                ->whereStatus(1)
                ->first();

                if(!$check_user){
                    return false;
                }
                
                if (Carbon::parse($check_user->updated_at) > Carbon::createFromTimestamp($time)) {
                    return Carbon::parse($check_user->updated_at). ' - ' .Carbon::createFromTimestamp($time);
                }

                return $check_user;
            } else {
                return false;
            }
        } catch (\Exception $e) {
            return false;
        }
    }

    public function blacklist($token){
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
