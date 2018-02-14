<?php
namespace Flyt\Handlers;

use Exception;

class ExceptionHandler implements \Illuminate\Contracts\Debug\ExceptionHandler
{

    /**
     * Report or log an exception.
     * @param  \Exception $e *
     * @return void
     */
    public function report(Exception $e)
    {
        throw $e;
    }


    public function render($request, Exception $e)
    {
        throw $e;
    }

    public function renderForConsole($output, Exception $e)
    {
        throw $e;
    }
}