<?php

use exceptions\BaseException;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
set_exception_handler("handleExceptions");

spl_autoload_register(function ($class){
    $class = str_replace("\\", DIRECTORY_SEPARATOR, $class) . ".php";
    require_once $class;
});

session_start();

require_once('components/router/Router.php');
require_once('app/Routes.php');

function handleExceptions($exception){
    $status = $exception instanceof BaseException ? $exception->getStatusCode() : 500;
    $msg = $exception->getMessage();
    if ($status == 500){
        echo $msg;
    }
    header($_SERVER["SERVER_PROTOCOL"]." " . $status);
    $html = "<h3 style='color: red'>$msg</h3>";
    echo $exception->getLine();
    echo $exception->getFile();
    include_once "view/main.php";
    echo $html;
}
