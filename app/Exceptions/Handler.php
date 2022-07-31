<?php

namespace App\Exceptions;

use Throwable;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Auth\AuthenticationException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Throwable  $exception
     * @return void
     */
    public function report(Throwable  $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Throwable  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Throwable  $exception)
    {
        if ($request->expectsJson()) {
            if(env('APP_DEBUG') === false) {
                if (strpos($request->url(), 'datatable') !== false) {
                    return json_encode(json_decode('{"draw":1,"recordsTotal":0,"recordsFiltered":0,"data":[]}'));
                } else {
                    return $this->JsonExport(500, 'Internal Server Error');
                }
            }
        }
        return parent::render($request, $exception);
    }

    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if (!$request->expectsJson()) {
            return redirect()->route('admin.page.login');
        } else {
            return $this->JsonExport(422, 'Unauthenticated');
        }
    }

    protected function JsonExport($code, $msg)
    {
        $callback = [
            'code' => $code,
            'msg' => $msg
        ];
        return response()->json($callback, 200, [], JSON_NUMERIC_CHECK);
    }
}
