<?php
 
namespace App\Exceptions;
 
use Exception;
 
class ExceptionDatatable extends Exception
{
    /**
     * Report the exception.
     *
     * @return void
     */
    public function report()
    {
    }
 
    /**
     * Render the exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function render($request)
    {
        return json_encode(json_decode('{"draw":1,"recordsTotal":0,"recordsFiltered":0,"data":[]}'));
    }
}