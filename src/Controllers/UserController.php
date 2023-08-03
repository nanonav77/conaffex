<?php

namespace App\Controllers;

use App\Config\ResponseHttp;
use App\Config\Security;
use App\Models\UserModel;
use Rakit\Validation\Validator;

class UserController extends BaseController{   
        
    /**********************Consultar un usuario por nombre de usuario*******************************/
    final public function getUsers(string $endPoint)
    {
        if ($this->getMethod() == 'get' && $endPoint == $this->getRoute()) {
            //Security::validateTokenJwt(Security::secretKey());
            echo json_encode(UserModel::getUsers());
            exit;            
        }    
    }
}