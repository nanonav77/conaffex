<?php

    use App\Config\ResponseHttp;
    use App\Controllers\FincaController;

    /*************Parametros enviados por la URL*******************/
    $params  = explode('/' ,$_GET['route']);

    /*************Instancia del controlador de una finca**************/
    $app = new FincaController();

    /*************Rutas***************/
    $app->postSave("finca/");
    $app->getAll("finca/");
    $app->getOne("finca/one/{$params[2]}/");
    $app->getFilter("finca/filter/{$params[2]}/");
    $app->updateSave("finca/update/");

    /****************Error 404*****************/
    echo json_encode(ResponseHttp::status404());