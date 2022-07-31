<?php

namespace App\Http\Controllers\Api\Notification;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    //
    public function __construct()
    {
        $this->instance = $this->instance(\App\Http\Helper\Api\Notification\Helper::class);
    }

    public function notification_get_list(Request $request){
        try{
            return $this->instance->apiGetNotificationList($request);
        }catch (\Exception $e) {
            $this->__writeLog500($request->ip(), $request->method(), $request->path(), $e);
            return $this->JsonExportAPI(500, config('constant.msg_500'));
        }
    }

    public function notification_add(Request $request){
        try{
            return $this->instance->apiAddNotification($request);
        }catch (\Exception $e) {
            $this->__writeLog500($request->ip(), $request->method(), $request->path(), $e);
            return $this->JsonExportAPI(500, config('constant.msg_500'));
        }
    }
    
    public function notification_get_from_mobile(Request $request){
        try{
            if($request->has('token') && $request->token == config('constant.XOR_KEY')){
                return $this->instance->apiGetNotificationListMobile($request);
            }else{
                return $this->JsonExportAPI(403, config('constant.msg_403'));
            }
            
        }catch (\Exception $e) {
            $this->__writeLog500($request->ip(), $request->method(), $request->path(), $e);
            return $this->JsonExportAPI(500, config('constant.msg_500'));
        }
    }

    public function notification_update_from_mobile(Request $request){
        try{
            if($request->has('token') && $request->token == config('constant.XOR_KEY')){
                return $this->instance->apiUpdateNotificationListMobile($request);
            }else{
                return $this->JsonExportAPI(403, config('constant.msg_403'));
            }
            
        }catch (\Exception $e) {
            $this->__writeLog500($request->ip(), $request->method(), $request->path(), $e);
            return $this->JsonExportAPI(500, config('constant.msg_500'));
        }
    }

    public function notification_count_from_mobile(Request $request){
        try{
            if($request->has('token') && $request->token == config('constant.XOR_KEY')){
                return $this->instance->apiCountNotificationListMobile($request);
            }else{
                return $this->JsonExportAPI(403, config('constant.msg_403'));
            }
            
        }catch (\Exception $e) {
            $this->__writeLog500($request->ip(), $request->method(), $request->path(), $e);
            return $this->JsonExportAPI(500, config('constant.msg_500'));
        }
    }
}
