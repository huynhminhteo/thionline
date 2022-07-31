<?php

namespace App\Http\Helper\Api\Core;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use App\Http\Helper\Helper as HelperBase;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Yajra\Datatables\Datatables;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Http\Request;
use Validator;
use Auth;
use Carbon\Carbon;
use App\Model;

class Helper extends HelperBase
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct(){
        parent::__construct();
    }

    public function apiGetListCore($request){
        try{
            $user = $this->getUser();
            if(!in_array($user->role, config('constant.login_teacher'))){
                return $this->JsonExportAPI(403, config('constant.msg_permission_denied'));
            }
            $core = Model\Core::all();
            return Datatables::of($core)
            ->editColumn('date',function($v){
                return Carbon::parse($v->date)->format('d-m-Y H:i');
            })
            ->addColumn('action',function($v){
                return '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 26.56024 23.01074"><defs><linearGradient id="grad1" x1="0%" y1="0%" x2="100%" y2="80%"><stop offset="0%" style="stop-color:#f9cd0b;stop-opacity:1"></stop><stop offset="50%" style="stop-color:#fef04a;stop-opacity:1"></stop><stop offset="100%" style="stop-color:#bef526;stop-opacity:1"></stop></linearGradient></defs><g id="e4528a06-49ca-45df-b291-0058939bff96" data-name="Layer 2" fill="url(#grad1)"><g id="b79c6ffe-bda4-4fa0-965c-5c7a461cd441" data-name="ID-34"><g id="adf61ab4-3bac-4ea0-a389-bf950c669575" data-name="menu のコピー 2"><g id="ef403de7-caf9-4ef2-9589-70177b37d0cb" data-name="グループ 1"><g id="affef90e-78f1-4289-b74d-f32c9bba042f" data-name="レイヤー 5 Image"><rect class="b5ebc80f-1571-4630-b042-336882c59e87" y="5.67041" width="4.10004" height="1.60767"/><rect class="b5ebc80f-1571-4630-b042-336882c59e87" x="6.37628" y="5.67041" width="9.40106" height="1.60767"/><rect class="b5ebc80f-1571-4630-b042-336882c59e87" x="6.37628" y="10.40259" width="9.40106" height="1.60767"/><rect class="b5ebc80f-1571-4630-b042-336882c59e87" x="6.37628" y="15.22876" width="7.11041" height="1.60742"/><rect class="b5ebc80f-1571-4630-b042-336882c59e87" y="15.22876" width="4.10004" height="1.60742"/><path class="b5ebc80f-1571-4630-b042-336882c59e87" d="M2.66187,1H17.75073a1.318,1.318,0,0,1,1.31641,1.31641V8.55029h1V2.31641A2.31893,2.31893,0,0,0,17.75073,0H1.66187V4.79346h1Z"/><path class="b5ebc80f-1571-4630-b042-336882c59e87" d="M19.06714,20.69434a1.31794,1.31794,0,0,1-1.31641,1.3164H2.66187v-4.3916h-1v5.3916H17.75073a2.31893,2.31893,0,0,0,2.31641-2.3164V17.35693h-1Z"/><rect class="b5ebc80f-1571-4630-b042-336882c59e87" x="1.66187" y="8.15479" width="1" height="6.10303"/><polygon class="b5ebc80f-1571-4630-b042-336882c59e87" points="14.813 15.243 15.026 17.671 17.454 17.884 24.933 10.405 22.292 7.764 14.813 15.243"/><rect class="b5ebc80f-1571-4630-b042-336882c59e87" x="23.81952" y="6.17811" width="1.66404" height="3.7346" transform="translate(1.531 19.78711) rotate(-44.99851)"/></g></g></g></g></g></svg>';
            })
            ->make(true);
        }catch (\Exception $e) {
            $this->__writeLog500($request->ip(), $request->method(), $request->path(), $e);
            return $this->JsonExportAPI(500, config('constant.msg_500'));
        }
    }
}