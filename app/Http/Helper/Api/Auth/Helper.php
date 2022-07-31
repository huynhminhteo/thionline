<?php

namespace App\Http\Helper\Api\Auth;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use App\Http\Helper\Helper as HelperBase;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Yajra\Datatables\Datatables;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\Filter;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Hash;
use Auth;
use Carbon\Carbon;
use \stdClass;
use App\Model;
use Storage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Crypt;
use App\Jobs\ForgotSendMail;

class Helper extends HelperBase
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        parent::__construct();
    }

    public function api_logout($request){
        try {
            DB::beginTransaction();
            $userData = auth('api')->user();
            $fcm = Model\Fcm::whereUserIdAndDeviceId($userData->id, $request->device_id)
            ->where('status',1)
            ->whereNull('deleted_at')
            ->first();
      
            if ($fcm) {
                $fcm->update([
                    'status' => 0
                ]);
                if ($fcm) {
                    DB::commit();
                    return $this->JsonExport(200, __('app.success'));
                } else {
                    DB::rollback();
                    return $this->JsonExport(403, __('app.update_fail'));
                }
            } else {
                DB::commit();
                return $this->JsonExport(200, __('app.success'));
            }
        } catch (\Exception $e) {
            DB::rollback();
            $this->__writeLog500($request->ip(), $request->method(), $request->path(), $e);
            return $this->JsonExportAPI(500, config('constant.msg_500'));
        }
    }

    public function apiChangePassword($request){
        try{
            $user = $this->getUser();
            DB::beginTransaction();
            $commit = Model\MUser::whereId($user->id)->update([
                'password' => Hash::make($request->password)
            ]);
            DB::commit();
            return $this->JsonExportAPI(200, config('constant.msg_200'));
        }catch (\Exception $e) {
            DB::rollback();
            $this->__writeLog500($request->ip(), $request->method(), $request->path(), $e);
            return $this->JsonExportAPI(500, config('constant.msg_500'));
        }
    }

    public function apiChangePasswordAdmin($request){
        try{
            $user = $this->getUser();
            if (Hash::check($request->oldpass, $user->password)) {
                DB::beginTransaction();
                $commit = Model\MUser::whereId($user->id)->update([
                    'password' => Hash::make($request->newpass)
                ]);
                DB::commit();
                return $this->JsonExportAPI(200, config('constant.msg_200'));
            }
            return $this->JsonExportAPI(403, '古いパスワードが間違っています');
        }catch (\Exception $e) {
            DB::rollback();
            $this->__writeLog500($request->ip(), $request->method(), $request->path(), $e);
            return $this->JsonExportAPI(500, config('constant.msg_500'));
        }
    }

    public function apiResetPassword($request){
        try{
            $check_user = Model\MUser::whereMail($request->mail)
            ->whereStatus(1)
            ->whereId($request->id)
            ->first();
            if(!$check_user){
                return $this->JsonExport(403, __('app.update_fail'));
            }

            DB::beginTransaction();
            $commit = $check_user->update([
                'password' => Hash::make($request->password)
            ]);
            DB::commit();
            return $this->JsonExportAPI(200, 'パスワードを変更しました');
        }catch (\Exception $e) {
            DB::rollback();
            $this->__writeLog500($request->ip(), $request->method(), $request->path(), $e);
            return $this->JsonExportAPI(500, config('constant.msg_500'));
        }
    }

    public function apiForgotPassword($request){
        try{
            $check_user = Model\MUser::whereMail($request->mail)
            ->whereStatus(1)
            ->whereHas('company',function($query) use ($request) {
                $query->whereCorpId($request->companyId) 
                ->where('status', '!=', 0);
            })
            ->whereIn('role', config('constant.login_app'))
            ->first();
            if(!$check_user){
                return $this->JsonExportAPI(403, 'メールアドレスが存在しません');
            }
            $time = time();
            $key = config('constant.XOR_KEY');
            $hash = md5($check_user->id . $check_user->mail . $time . $key.$check_user->role) ;
            $token = base64_encode($check_user->id . '|' . $check_user->mail . '|' . $time . '|' . $hash .'|'.$check_user->role);
            //send link to mail
            $link = config('constant.admin_url').'/reset-password/'.$token;
           
            ForgotSendMail::dispatch($check_user->mail,$link);
            return $this->JsonExportAPI(200, 'パスワードリセットリンクがメールアドレスに送信されました。ご確認ください');
        }catch (\Exception $e) {
            DB::rollback();
            $this->__writeLog500($request->ip(), $request->method(), $request->path(), $e);
            return $this->JsonExportAPI(500, config('constant.msg_500'));
        }
    }

    public function apiForgotPasswordAdmin($request){
        try{
            $check_user = Model\MUser::whereMail($request->mail)
            ->whereStatus(1)
            ->whereHas('company',function($query) use ($request) {
                $query->whereCorpId($request->companyId) 
                ->where('status', '!=', 0);
            })
            ->whereIn('role', config('constant.login_admin'))
            ->first();
            if(!$check_user){
                return $this->JsonExportAPI(403, 'メールアドレスが存在しません');
            }
            $time = time();
            $key = config('constant.XOR_KEY');
            $hash = md5($check_user->id . $check_user->mail . $time . $key . $check_user->role);
            $token = base64_encode($check_user->id . '|' . $check_user->mail . '|' . $time . '|' . $hash.'|'.$check_user->role);
            //send link to mail
            $link = config('constant.admin_url').'/reset-password/'.$token;
           
            ForgotSendMail::dispatch($check_user->mail,$link);
            return $this->JsonExportAPI(200, 'パスワードリセットリンクがメールアドレスに送信されました。ご確認ください');
        }catch (\Exception $e) {
            DB::rollback();
            $this->__writeLog500($request->ip(), $request->method(), $request->path(), $e);
            return $this->JsonExportAPI(500, config('constant.msg_500'));
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

    //OPERATOR
    public function apiLoginOperator($request){
        try {
            $credentials = [
                'mail' => $request->mail,
                'password' => $request->password
            ];

            $check_user = Model\MUser::whereMail($request->mail)->first();
            if(!$check_user){
                return $this->JsonExportAPI(403, config('constant.login_wrong').' 123');
            }
            if (!$token = auth('api')->attempt($credentials)) {
                return $this->JsonExportAPI(403, config('constant.login_wrong').' 456');
            }

            $user = auth('api')->user();

            return $this->JsonExportAPI(200, config('constant.msg_200'), ['token' => $token] );
        } catch (\Exception $e) {
            $this->__writeLog500($request->ip(), $request->method(), $request->path(), $e);
            return $this->JsonExportAPI(500, config('constant.msg_500'));
        }
    }

    public function changePasswordAdmin($request){
        try{
            $user = $this->getUser();
            DB::beginTransaction();

            if (Hash::check($request->oldpass, $user->password)) {
                DB::beginTransaction();
                $commit = Model\MUser::whereId($user->id)->update([
                    'password' => Hash::make($request->newpass)
                ]);
                DB::commit();
            } else {
                return $this->JsonExportAPI(403, '古いパスワードが間違っています');
            }

            DB::commit();
            return $this->JsonExportAPI(200, 'パスワード変更が完了しました');
        } catch (\Exception $e) {
            DB::rollback();
            $this->__writeLog500($request->ip(), $request->method(), $request->path(), $e);
            return $this->JsonExportAPI(500, config('constant.msg_500'));
        }
    }
}