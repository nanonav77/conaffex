<?php

namespace App\Controllers;

use App\Config\ResponseHttp;
use App\Config\Security;
use App\Models\ColaboradorModel;
use Rakit\Validation\Validator;

class ColaboradorController extends BaseController{   
        
    /**********************Consultar toda la lista de colaboradores*******************************/
    final public function getAll(string $endPoint)
    {
        if ($this->getMethod() == 'get' && $endPoint == $this->getRoute()) {
            //Security::validateTokenJwt(Security::secretKey());
            echo json_encode(ColaboradorModel::getAll());
            exit;            
        }    
    }

    /************************************Función para crear un colaborador nuevo***********************************************/
    final public function postSave(string $endPoint)
    {
        if ($this->getMethod() == 'post' && $endPoint == $this->getRoute()) {
       
            $validator = new Validator;
            
            $validation = $validator->validate($this->getParam(), [
                'identificacion'  => 'required|numeric|min:10|regex:/^[1234567890]+$/',
                'nombre'          => 'required|regex:/^[a-zA-Z ]+$/',
                'telefono'        => 'required|numeric|min:8|regex:/^[1234567890]+$/',
                'tarjeta'         => 'required|numeric|min:16|regex:/^[1234567890]+$/',
                'observaciones'   => 'required|regex:/^[a-zA-Z ]+$/',
                'tipo'            => 'required|regex:/^[a-zA-Z ]+$/',
                'genero'          => 'required|regex:/^[a-zA-Z ]+$/'

            ]);      

        if ($validation->fails()) {            
            $errors = $validation->errors();            	
            echo json_encode(ResponseHttp::status400($errors->all()[0]));
        } else {          
            new ColaboradorModel($this->getParam());
            echo json_encode(ColaboradorModel::postSave());
        }                            
        exit;
       }
    } 

    /**********************Consultar un colaborador por número*******************************/
    final public function getOne(string $endPoint)
    {
        if ($this->getMethod() == 'get' && $endPoint == $this->getRoute()) {
            //Security::validateTokenJwt(Security::secretKey());
            $numero = $this->getAttribute()[1];
            if (!isset($numero)) {
                echo json_encode(ResponseHttp::status400('El campo número de colaborador es requerido'));
            } else {
                ColaboradorModel::setNumero($numero);
                echo json_encode(ColaboradorModel::getOne());
                exit;
            }  
            exit;
        }    
    }

    /**********************Consultar colaboradores por número o nombre buscado*******************************/
    final public function getFilter(string $endPoint)
    {
        if ($this->getMethod() == 'get' && $endPoint == $this->getRoute()) {
            //Security::validateTokenJwt(Security::secretKey());
            $filtro= $this->getAttribute()[1];
            if (!isset($filtro)) {
                echo json_encode(ResponseHttp::status400('Por favor ingrese el dato buscado'));
            } else {
                echo json_encode(ColaboradorModel::getFilter($filtro));
                exit;
            }  
            exit;
        }    
    }
}