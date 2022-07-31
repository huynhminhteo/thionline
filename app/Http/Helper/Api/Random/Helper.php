<?php

namespace App\Http\Helper\Api\Random;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Collection;
use App\Http\Helper\Helper as HelperBase;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables;
use Spatie\QueryBuilder\QueryBuilder;
use Auth;
use Carbon\Carbon;
use App\Model;

class Helper extends HelperBase
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct(){
        parent::__construct();
    }

    public function apiRandom($request) {
        try {
            $user = $this->getUser();
            
            return $this->JsonExportAPI(200, config('constant.msg_200'), $user->test_id); 
        } catch (\Exception $e) {
            $this->__writeLog500($request->ip(), $request->method(), $request->path(), $e);
            return $this->JsonExportAPI(500, config('constant.msg_500'));
        }
    }
}