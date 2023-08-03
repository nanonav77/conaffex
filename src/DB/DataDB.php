<?php

    use App\Config\ErrorLog;
    use App\Config\ResponseHttp;
    use App\DB\ConnectionDB;

    ErrorLog::activateErrorLog();

    $dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__,2));
    $dotenv->load();

    /*********Datos de conexión*********/
    $data = array(
        'HOST_DB'  => $_ENV['HOST_DB'],
        'USER_DB'  => $_ENV['USER_DB'],
        'PASSWORD_DB' => $_ENV['PASSWORD_DB'],
        'INSTANCIA_DB'=> $_ENV['INSTANCIA_DB'],
        'PORT_DB'  => $_ENV['PORT_DB']
    );

    $host  = 'mysql:host='.$data['HOST_DB'].';'.'port='.$data['PORT_DB'].';'. 'dbname='.$data['INSTANCIA_DB'];

    ConnectionDB::from($host,$data['USER_DB'],$data['PASSWORD_DB']);