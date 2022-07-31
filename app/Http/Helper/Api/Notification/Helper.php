<?php

namespace App\Http\Helper\Api\Notification;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Collection;
use App\Http\Helper\Helper as HelperBase;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Yajra\Datatables\Datatables;
use Illuminate\Http\Request;
use Carbon\Carbon;
use \stdClass;
use App\Model;
use App\Jobs\PushNotification;


class Helper extends HelperBase
{
    use AuthorizesRequests, DispatchesJobs;

    public function __construct()
    {
        parent::__construct();
    }

    public function apiGetNotificationList($request){
        try{
            return Datatables::of(Model\MNotification::query() 
            ->orderBy('id','desc')
            ->limit(50)
            )
           
            ->addColumn('date_create',function($v){
                return Carbon::parse($v->insert_at)->format('Y/m/d');
            })
            ->addColumn('user_create',function($v){
                return $v->mUser->name;
            })
            ->makeHidden([
                'insert_user',
                'update_user',
                'insert_at',
                'update_at',
                'created_at',
                'updated_at'
                ])
            ->make(true);
            
        }catch (\Exception $e) {
            DB::rollback();
            $this->__writeLog500($request->ip(), $request->method(), $request->path(), $e);
            return $this->JsonExportAPI(500, config('constant.msg_500'));
        }
    }

    public function apiAddNotification($request){
        try{
            $user = $this->getUser();
            $fcm_list = Model\Fcm::whereHas('mUser',function($query){
                $query->whereIn('role',[5,6,7,8])
                ->whereHas('company',function($q){
                    $q->whereIn('status',[1,2]);
                });
            })
            ->pluck('fcm_token');
            // Insert DB
            Model\MNotification::create([
                'insert_user' => $user->id,
                'update_user' => $user->id,
                'title' => $request->title,
                'content' => $request->content
            ]);
            // check list over 500 token 
            // https://firebase.google.com/docs/cloud-messaging/send-message#send-messages-to-multiple-devices
            if(count($fcm_list) > 500){
                foreach(array_chunk($fcm_list,500) as $value){
                    PushNotification::dispatch($request->title, $request->content, $value);
                }
            }else{
                PushNotification::dispatch($request->title, $request->content, $fcm_list);
            }
            return $this->JsonExportAPI(200, config('constant.msg_200')); 
        }catch (\Exception $e) {
            DB::rollback();
            $this->__writeLog500($request->ip(), $request->method(), $request->path(), $e);
            return $this->JsonExportAPI(500, config('constant.msg_500'));
        }
    }

    public function apiGetNotificationListMobile($request){
        try{
            $data = Model\MNotification::with('mUserRead')
            ->orderBy('insert_at','desc');
           
            $pagination = true;
            if ($pagination) {
                if ($request->has('per_page') && !empty($request->per_page)) {
                    $paginate = $request->per_page;
                } else {
                    $paginate = 50;
                }
                $data = $data->paginate($paginate)->appends(request()->query());
            } else {
                $data = $data->get();
            }

            return $this->JsonExportAPI(200, config('constant.msg_200'), $data);
        }catch (\Exception $e) {
            $this->__writeLog500($request->ip(), $request->method(), $request->path(), $e);
            return $this->JsonExportAPI(500, config('constant.msg_500'));
        }
    }

    public function apiUpdateNotificationListMobile($request){
        try{
            $check_notification = Model\MNotification::find($request->id_notification);
            $check_user = Model\MUser::find($request->id_user);
            DB::beginTransaction();
            if($check_notification && $check_user){
                $check_read = Model\TUsersNotification::whereIdNotification($request->id_notification)
                ->whereIdUser($request->id_user)
                ->first();
                if(!$check_read){
                    $data = [
                        'id_notification' => $request->id_notification,
                        'id_user'         => $request->id_user
                    ];
                    Model\TUsersNotification::insert($data);
                }
            }
            DB::commit();
            return $this->JsonExportAPI(200, config('constant.msg_200'));
        }catch (\Exception $e) {
            DB::rollback();
            $this->__writeLog500($request->ip(), $request->method(), $request->path(), $e);
            return $this->JsonExportAPI(500, config('constant.msg_500'));
        }
    }

    public function apiCountNotificationListMobile($request){
        try{
            $check_user = Model\MUser::find($request->id_user);
            $count_noti_un_read = Model\MNotification::whereDoesntHave('mUserRead',function($query) use ($check_user){
                $query->where('id',$check_user->id);
            })
			->with('mUserRead')
            ->count();
            return $this->JsonExportAPI(200, config('constant.msg_200'),$count_noti_un_read);
        }catch (\Exception $e) {
            DB::rollback();
            $this->__writeLog500($request->ip(), $request->method(), $request->path(), $e);
            return $this->JsonExportAPI(500, config('constant.msg_500'));
        }
    }
}