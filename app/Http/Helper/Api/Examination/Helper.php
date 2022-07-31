<?php

namespace App\Http\Helper\Api\Examination;

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
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Crypt;
use App\Jobs\SendMail;
use Dompdf\Dompdf;
use Dompdf\Options;

class Helper extends HelperBase
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct(){
        parent::__construct();
    }

    public function apiUploadRecord($request) {
        try {
            $user = $this->getUser();
            $file = $request->file('audio_data');
            $path = $user->name . " - Đề số " . $request->test . " - Phần thi số " . $request->group . " - Câu" . $request->question . ".mp3";
            Storage::disk('public_audio')->put($path, file_get_contents($file));
        } catch (\Exception $e) {
            $this->__writeLog500($request->ip(), $request->method(), $request->path(), $e);
            return $this->JsonExportAPI(500, config('constant.msg_500'));
        }
    }
}