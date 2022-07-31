<?php
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/','Auth\AuthController@api_index')->name('api.admin.index');
Route::post('/login/v1','Auth\AuthController@api_login')->name('api.login.post');
Route::post('/login/attendance/v1','Auth\AuthController@api_login_attendance')->name('api.login.attendance.post');
Route::post('/forgot-admin/v1','Auth\AuthController@api_forgot_admin')->name('api.forgot.admin.post');
Route::post('/forgot/v1','Auth\AuthController@api_forgot')->name('api.forgot.post');
Route::post('/check_user/v1','Auth\AuthController@api_check_user')->name('api.check.user.post');
Route::post('/reset-password/v1','Auth\AuthController@api_reset_password')->name('api.reset.password.post');

//OPERATOR
Route::post('/login/operator/v1','Auth\AuthController@api_login_operator')->name('api.login.operator.post');

Route::group(['middleware' => ['auth.api', 'jwt.blacklist']], function () {
    Route::post('/changepw/v1','Auth\AuthController@api_change_password')->name('api.change.password.post');
    Route::post('/changepw_admin/v1','Auth\AuthController@api_change_password_admin')->name('api.change.password.admin.post');
    Route::post('/change-password/v1', 'Auth\AuthController@api_change_pw_admin')->name('api.change.pw.admin.post');

    //User
    Route::group(['namespace' => 'User'], function () {
        Route::get('/user/v1', 'UserController@api_get_users')->name('api.user.get');
        Route::post('/user/add/v1', 'UserController@api_add_user')->name('api.user.add.post');
        Route::post('/user/update/v1', 'UserController@api_update_user')->name('api.user.update.post');
        Route::post('/user/delete/v1', 'UserController@api_delete_user')->name('api.user.delete.post');
        Route::post('/user/operator/add/v1', 'UserController@api_add_user_operator')->name('api.user.operator.add.post');
    });

    //Company
    Route::group(['namespace' => 'Company', 'prefix' => 'company'], function () {
        Route::get('/get/v1', 'CompanyController@api_get_company')->name('api.get.company.get');
        Route::post('/update/v1', 'CompanyController@api_update_company')->name('api.update.company.post');
    });

    // Contract
    Route::group(['namespace' => 'Contract', 'prefix' => 'contract'], function () {
        Route::get('/company/v1', 'ContractController@api_get_contract_company')->name('api.get.contract.company.get');
        Route::post('/cancel/v1', 'ContractController@api_cancel_contract_company')->name('api.cancel.contract.company.post');
        Route::post('/company/use/v1', 'ContractController@api_update_status_company')->name('api.get.contract.company.use.post');
        Route::get('/plans/v1', 'ContractController@api_get_all_plan')->name('api.get.all.plans.get');
        Route::post('/plans/change/v1', 'ContractController@api_contract_change_plan')->name('api.contract.change.plan.post');
        Route::get('/all/v1', 'ContractController@api_get_all_contract')->name('api.get.all.contract.get');
        Route::post('/detail/company/v1', 'ContractController@api_get_detail_company')->name('api.get.detail.company.post');
        Route::get('/detail/contract/v1', 'ContractController@api_get_detail_all_contract')->name('api.get.detail.all.contract.get');
        Route::post('/detail/export-bill/v1', 'ContractController@api_export_bill')->name('api.export.bill.post');
        Route::post('/detail/export-receipt/v1', 'ContractController@api_export_receipt')->name('api.export.receipt.post');
        Route::get('/summary/v1', 'ContractController@api_get_summary_contract')->name('api.get.summary.contract.get');
    });

    // Notification 
    Route::group(['namespace' => 'Notification', 'prefix' => 'notification'], function () {
        Route::get('/v1', 'NotificationController@notification_get_list')->name('operator.medical.notification.list.get');
        Route::post('add/v1', 'NotificationController@notification_add')->name('operator.medical.notification.add.post');
    });

    // CORE 
    Route::group(['namespace' => 'Core', 'prefix' => 'core'], function () {
        Route::get('/v1', 'CoreController@api_get_list_core');
        Route::post('add/v1', 'CoreController@notification_add');
    });

    // TEST 
    Route::group(['namespace' => 'Test', 'prefix' => 'test'], function () {
        Route::get('/v1', 'TestController@api_get_list_test');
        Route::post('add/v1', 'TestController@notification_add');
    });

    // GROUP 
    Route::group(['namespace' => 'Group', 'prefix' => 'group'], function () {
        Route::get('/v1', 'GroupController@api_get_list_group');
        Route::post('add/v1', 'GroupController@notification_add');
    });

    // EXAMINATION 
    Route::group(['namespace' => 'Examination', 'prefix' => 'examination'], function () {
        Route::post('record', 'ExaminationController@api_upload_record');
    });

    // RANDOM 
    Route::group(['namespace' => 'Random', 'prefix' => 'random'], function () {
        Route::get('/v1', 'RandomController@api_random');
    });

});
// Notification call from mobile
Route::post('notification/get/v1', 'Notification\NotificationController@notification_get_from_mobile')->name('operator.medical.notification.get.mobile.get');
Route::post('notification/update/v1', 'Notification\NotificationController@notification_update_from_mobile')->name('operator.medical.notification.update.mobile.get');
Route::post('notification/count/v1', 'Notification\NotificationController@notification_count_from_mobile')->name('operator.medical.notification.count.mobile.get');
// API external order

// OA001 set_company_info
Route::post('/set_company_info/v1','External\ExternalController@api_set_company_info')->name('api.external.set.company.info.post');
// OA002 change_settlement_status
Route::post('/change_settlement_status/v1','External\ExternalController@api_change_settlement_status')->name('api.change.settlement.status.post');
// OA003 get_customer_id
Route::post('/get_customer_id/v1','External\ExternalController@api_get_customer_id')->name('api.external.get.customer.id.post');
// OA004 change_card
Route::post('/change_card/v1','External\ExternalController@api_change_card')->name('api.external.change.card.post');

// API upgrade all company from trial to normal
Route::post('/upgrade/trial/v1','External\ExternalController@api_upgrade_trial')->name('api.external.upgrade.trial.post')->middleware('auth.basic.mainte');
