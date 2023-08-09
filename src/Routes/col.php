<?php

    use App\Config\ResponseHttp;
    use App\Controllers\ColaboradorController;

    /*************Parametros enviados por la URL*******************/
    $params  = explode('/' ,$_GET['route']);

    /*************Instancia del controlador de usuario**************/
    $app = new ColaboradorController();

    /*************Rutas***************/
    $app->postSave("col/");
    $app->getAll("col/");
    $app->getOne("col/one/{$params[2]}/");
    $app->getFilter("col/filter/{$params[2]}/");
    $app->updateSave("col/update/");

    /****************Error 404*****************/
    echo json_encode(ResponseHttp::status404());