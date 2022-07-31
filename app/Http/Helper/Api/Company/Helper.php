<?php

namespace App\Http\Helper\Api\Company;

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

class Helper extends HelperBase
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct(){
        parent::__construct();
    }

    public function apiGetCompany($request){
        try{
            $user = $this->getUser();
         
            $company = Model\MCompany::whereId($user->company_id)
            ->whereStatus(1)
            ->first();
            if ($company)
            $company = $company->makeHidden([
                'insert_user',
                'update_user',
                'update_at',
                'insert_at',
                'corp_id',
                'status',
                'updated_at',
                'created_at',
                'contract_date'
            ]);
            return self::JsonExportApi(200, config('constant.msg_200'),$company); 
        }catch (\Exception $e) {
            $this->__writeLog500($request->ip(), $request->method(), $request->path(), $e);
            return $this->JsonExportAPI(500, config('constant.msg_500'));
        }
    }

    public function apiUpdateCompany($request){
        try{
            $user = $this->getUser();
            if(!in_array($user->role, [3])){
                return $this->JsonExportAPI(403, config('constant.msg_permission_denied'));
            } 
            DB::beginTransaction();
            $data = [
                'name'                  => $request->name,
                'name_kana'             => $request->name_kana,
                'office_name'           => $request->office_name,
                'office_name_kana'      => $request->office_name_kana,
                'post_code'             => $request->post_code,
                'address'               => $request->address,
                'building'              => $request->building,
                'phone'                 => $request->phone,
                'fax'                   => $request->fax,
                'account_manager_name'  => $request->account_manager_name,
                'mail'                  => $request->mail 
            ];
            Model\MCompany::whereId($user->company_id)->update($data);
            DB::commit();
            return self::JsonExportApi(200, config('constant.msg_200')); 
        }catch (\Exception $e) {
            DB::rollback();
            $this->__writeLog500($request->ip(), $request->method(), $request->path(), $e);
            return $this->JsonExportAPI(500, config('constant.msg_500'));
        }
    }
}