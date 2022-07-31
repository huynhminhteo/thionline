<?php

namespace App\Http\Controllers\Api\Contract;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;

class ContractController extends Controller
{
    public function __construct(){
        $this->instance = $this->instance(\App\Http\Helper\Api\Contract\Helper::class);
    }
    
    public function api_get_contract_company(Request $request){
        try{
            return $this->instance->apiGetContractCompany($request);
        }catch (\Exception $e) {
            $this->__writeLog500($request->ip(), $request->method(), $request->path(), $e);
            return $this->JsonExportAPI(500, config('constant.msg_500'));
        }
    }

    public function api_get_all_plan(Request $request){
        try{
            return $this->instance->apiGetAllPlan($request);
        }catch (\Exception $e) {
            $this->__writeLog500($request->ip(), $request->method(), $request->path(), $e);
            return $this->JsonExportAPI(500, config('constant.msg_500'));
        }
    }

    public function api_get_all_contract(Request $request){
        try{
            return $this->instance->apiGetAllContract($request);
        }catch (\Exception $e) {
            $this->__writeLog500($request->ip(), $request->method(), $request->path(), $e);
            return $this->JsonExportAPI(500, config('constant.msg_500'));
        }
    }

    public function api_get_detail_company(Request $request){
        try{
            return $this->instance->apiGetDetailCompany($request);
        }catch (\Exception $e) {
            $this->__writeLog500($request->ip(), $request->method(), $request->path(), $e);
            return $this->JsonExportAPI(500, config('constant.msg_500'));
        }
    }

    public function api_get_detail_all_contract(Request $request){
        try{
            return $this->instance->apiGetDetailAllContract($request);
        }catch (\Exception $e) {
            $this->__writeLog500($request->ip(), $request->method(), $request->path(), $e);
            return $this->JsonExportAPI(500, config('constant.msg_500'));
        }
    }

    public function api_update_status_company(Request $request){
        try{
            return $this->instance->apiUpdateStatusCompany($request);
        }catch (\Exception $e) {
            $this->__writeLog500($request->ip(), $request->method(), $request->path(), $e);
            return $this->JsonExportAPI(500, config('constant.msg_500'));
        }
    }

    public function api_get_summary_contract(Request $request){
        try{
            return $this->instance->apiGetSummaryContract($request);
        }catch (\Exception $e) {
            $this->__writeLog500($request->ip(), $request->method(), $request->path(), $e);
            return $this->JsonExportAPI(500, config('constant.msg_500'));
        }
    }

    public function api_cancel_contract_company(Request $request){
        try{
            return $this->instance->apiCancelContractCompany($request);
        }catch (\Exception $e) {
            return $e->getMessage();
            $this->__writeLog500($request->ip(), $request->method(), $request->path(), $e);
            return $this->JsonExportAPI(500, config('constant.msg_500'));
        }
    }

    public function api_contract_change_plan(Request $request){
        try{
            return $this->instance->apiContractChangePlan($request);
        }catch (\Exception $e) {
            return $e->getMessage();
            $this->__writeLog500($request->ip(), $request->method(), $request->path(), $e);
            return $this->JsonExportAPI(500, config('constant.msg_500'));
        }
    }

    public function api_export_bill(Request $request) {
        try {
            return $this->instance->exportBill($request);
        } catch (\Exception $e) {
            $this->__writeLog500($request->ip(), $request->method(), $request->path(), $e);
            return $this->JsonExportAPI(500, config('constant.msg_500'));
        }
    }

    public function api_export_receipt(Request $request) {
        try {
            return $this->instance->exportReceipt($request);
        } catch (\Exception $e) {
            $this->__writeLog500($request->ip(), $request->method(), $request->path(), $e);
            return $this->JsonExportAPI(500, config('constant.msg_500'));
        }
    }
}
