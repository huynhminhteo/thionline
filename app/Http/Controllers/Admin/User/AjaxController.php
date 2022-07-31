<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AjaxController extends Controller
{
    //
    protected $instance;

    public function __construct()
    {
        $this->instance = $this->instance(\App\Http\Helper\Admin\User\Helper::class);
    }

    public function admin_user_datatable(Request $request)
    {
        try {
            return $this->instance->getUserDT($request);
        } catch (\Exception $e) {
            throw new \App\Exceptions\ExceptionDatatable();
        }
    }
}
