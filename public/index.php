<?php

use App\Config\ErrorLog;
use App\Config\ResponseHttp;

    require dirname(__DIR__) . '/vendor/autoload.php';

    ResponseHttp::headerHttpDev($_SERVER['REQUEST_METHOD']);
    //ResponseHttp::headerHttpPro($_SERVER['REQUEST_METHOD'],$_SERVER['HTTP_ORIGIN']);
    ErrorLog::activateErrorLog();

    if (isset($_GET['route'])){

        $url = explode('/',$_GET['route']);
        $lista = ['auth','user','col','finca'];
        $file = dirname(__DIR__) . '/src/Routes/' .$url[0]. '.php';

        if(!in_array($url[0],$lista)){
            echo json_encode(ResponseHttp::status400());
            error_log('esto es una prueba');
            exit;
        }

        if(is_readable($file)){
            
            require $file;
            exit;
        } else {
            echo json_encode(ResponseHttp::status400());
        }
    }

    else{
        echo json_encode(ResponseHttp::status404());
        exit;
    }