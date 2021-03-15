<?php
/*

ini_set("error_reporting", E_ALL);

//set error-handler but only for E_USER_ERROR and E_RECOVERABLE_ERROR
set_error_handler ('handle_error');

function handle_error ($errno, $error, $file, $line, $context)
{
    global $scouter;
    $message = "[ERROR][$errno][$error][$file:$line]";
    $scouter['handle_error'][] = [
        'errno' => $errno,
        'error' => $error,
        'file' => $file,
        'line' => $line
    ];
}



//exception-handler
set_exception_handler ('handle_exception');

//function for exception handling
function handle_exception (Exception $exception)
{
    global $scouter;
    $scouter['handle_exception'][] = $exception->getMessage();
//     print_r($exception->getMessage());
}



*/
