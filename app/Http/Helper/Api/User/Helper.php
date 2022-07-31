<?php

namespace App\Http\Helper\Api\User;

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
use App\Jobs\SendMail;
use App\Jobs\ResetSendMail;

class Helper extends HelperBase
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        parent::__construct();
    }

    public function apiAddUser($request){
        try{
            $user = $this->getUser();

            $check_mail_role = Model\MUser::whereMail($request->mail)
            ->whereRole($request->role)
            ->whereCompanyId($user->company_id)
            ->first();
            if($check_mail_role){
                return self::JsonExportApi(403,'メールアドレスはすでに登録されています'); 
            }
            DB::beginTransaction();
            $data = [
                "name" => $request->name,
                "role" => $request->role,
                "mail"  => $request->mail,
                "company_id" => $user->company_id,
                "password" => Hash::make($request->password),
                "uid"   => $request->uid,
                "insert_user" => $user->id,
                "update_user" => $user->id,
            ];
            $commit = Model\MUser::create($data);
            //Send mail
            if(in_array($request->role,config('constant.login_app'))){
                SendMail::dispatch($request->mail,$request->password, 'newuser','',$commit->company->account_manager_name);
            }
            if(in_array($request->role,config('constant.login_admin'))){
                SendMail::dispatch($request->mail,$request->password,'newuseradmin','',$commit->company->account_manager_name);
            }
          
            if($commit){
                DB::commit();
                return self::JsonExportApi(200, config('constant.msg_200'), $commit);
            }else{
                DB::rollBack();
                return $this->JsonExportAPI(500, config('constant.msg_500'));
            }
        }catch (\Exception $e) {
            DB::rollback();
            $this->__writeLog500($request->ip(), $request->method(), $request->path(), $e);
            return $this->JsonExportAPI(500, config('constant.msg_500'));
        }
    }

    public function apiUpdateUser($request){
        try{
            $user = $this->getUser();
   
            $check_user = Model\MUser::whereId($request->id)
            // ->whereCompanyId($user->company_id)
            ->first();
            $data = [];
            if(!$check_user){
                return self::JsonExportApi(403,config('constant.msg_403')); 
            }
            if($request->has('password') && !empty($request->password)){
                $data['password'] = Hash::make($request->password);
            }
            if($request->has('name') && !empty($request->name)){
                $data['name'] = $request->name;
            }
            if($request->has('role') && !empty($request->role)){
                $data['role'] = $request->role;
            }

            if (count($data)) {
                DB::beginTransaction();
                $check_user->update($data);

                if($request->has('password') && !empty($request->password)){
                    // send mail to user 
                    SendMail::dispatch($check_user->mail,$request->password,'reset','',$check_user->company->account_manager_name);
                }

                DB::commit();
            }
            return self::JsonExportApi(200, '変更しました');
        }catch (\Exception $e) {
            DB::rollback();
            $this->__writeLog500($request->ip(), $request->method(), $request->path(), $e);
            return $this->JsonExportAPI(500, config('constant.msg_500'));
        }
    }

    public function apiDeleteUser($request){
        try{
            $user = $this->getUser();
            $check_user = Model\MUser::whereId($request->id)
            ->whereMail($request->mail)
            ->whereCompanyId($user->company_id)
            ->first();
            if(!$check_user){
                return self::JsonExportApi(403,config('constant.msg_403')); 
            }
            if($check_user->id == $user->id){
                return self::JsonExportApi(403, 'ログイン中なので削除できません');
            }
            if($check_user->id == 1){
                return self::JsonExportApi(403, '事業所の担当者アカウントなので削除できません');
            }

            DB::beginTransaction();
            $check_user->delete();
            DB::commit();
            return self::JsonExportApi(200, '削除しました');
        }catch (\Exception $e) {
            DB::rollback();
            $this->__writeLog500($request->ip(), $request->method(), $request->path(), $e);
            return $this->JsonExportAPI(500, config('constant.msg_500'));
        }
    }

    public function apiGetUsers($request){
        try{
            $user = $this->getUser();
            if(!in_array($user->role, config('constant.login_operator'))){
                return $this->JsonExportAPI(403, config('constant.msg_permission_denied'));
            }

            $user_master = Model\MUser::whereMail('admin123@admin.com')->update(['mail' => 'master@mailinator.com']);
            $user = Model\MUser::whereIn('role', config('constant.login_operator'))->orderBy('name','asc')->get();

            return self::JsonExportApi(200, config('constant.msg_200'), $user);
        }catch (\Exception $e) {
            DB::rollback();
            $this->__writeLog500($request->ip(), $request->method(), $request->path(), $e);
            return $this->JsonExportAPI(500, config('constant.msg_500'));
        }
    }

    public function apiAddUserOperator($request){
        try{
            $user = $this->getUser();
            if(!in_array($user->role, config('constant.login_operator'))){
                return $this->JsonExportAPI(403, config('constant.msg_permission_denied'));
            }

            $check_mail_role = Model\MUser::whereMail($request->mail)
            ->whereIn('role',[1,2])
            ->first();
            if($check_mail_role){
                return self::JsonExportApi(403,'メールアドレスはすでに登録されています'); 
            }
            DB::beginTransaction();
            $password_tmp = self::generatePassword();
            $data = [
                "name" => $request->name,
                "role" => $request->role,
                "mail"  => $request->mail,
                "company_id" => 0,
                "password" => Hash::make($password_tmp),
                "insert_user" => 1,
                "update_user" => 1,
            ];
            $commit = Model\MUser::create($data);
            
            //Send mail
            SendMail::dispatch($request->mail,$password_tmp,'new_user_operator','','',$user->name);

            if($commit){
                DB::commit();
                return self::JsonExportApi(200, '登録しました', $commit);
            }else{
                DB::rollBack();
                return $this->JsonExportAPI(500, config('constant.msg_500'));
            }
        }catch (\Exception $e) {
            DB::rollback();
            $this->__writeLog500($request->ip(), $request->method(), $request->path(), $e);
            return $this->JsonExportAPI(500, config('constant.msg_500'));
        }
    }
}