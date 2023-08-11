<?php

namespace App\Controllers;

use App\Config\ResponseHttp;
use App\Config\Security;
use App\Models\FincaModel;
use Rakit\Validation\Validator;

class FincaController extends BaseController{  

    /**********************Consultar toda la lista de fincas*******************************/
    final public function getAll(string $endPoint)
    {
        if ($this->getMethod() == 'get' && $endPoint == $this->getRoute()) {
            //Security::validateTokenJwt(Security::secretKey());
            echo json_encode(FincaModel::getAll());
            exit;            
        }    
    }

    /************************************Función para crear una nueva finca***********************************************/
    final public function postSave(string $endPoint)
    {
        if ($this->getMethod() == 'post' && $endPoint == $this->getRoute()) {
       
            $validator = new Validator;
            
            $validation = $validator->validate($this->getParam(), [
                'nombre'       => 'required|regex:/^[a-zA-Z ]+$/',
                'tamano'       => 'required|numeric|between:1,100',
                'ubicacion'    => 'required|regex:/^[a-zA-Z ]+$/',
                'propietario'  => 'required|numeric|min:1|regex:/^[1234567890]+$/'
            ]);      

        if ($validation->fails()) {            
            $errors = $validation->errors();            	
            echo json_encode(ResponseHttp::status400($errors->all()[0]));
        } else {          
            new FincaModel($this->getParam());
            echo json_encode(FincaModel::postSave());
        }                            
        exit;
       }
    }
    
    /**********************Consultar una finca por número*******************************/
    final public function getOne(string $endPoint)
    {
        if ($this->getMethod() == 'get' && $endPoint == $this->getRoute()) {
            //Security::validateTokenJwt(Security::secretKey());
            $numero = $this->getAttribute()[2];
            if (!isset($numero)) {
                echo json_encode(ResponseHttp::status400('El campo número de finca es requerido'));
            } else {
                FincaModel::setNumero($numero);
                echo json_encode(FincaModel::getOne());
                exit;
            }  
            exit;
        }    
    }

    /**********************Consultar finca por número o nombre buscado*******************************/
    final public function getFilter(string $endPoint)
    {
        if ($this->getMethod() == 'get' && $endPoint == $this->getRoute()) {
            //Security::validateTokenJwt(Security::secretKey());
            $filtro= $this->getAttribute()[2];
            if (!isset($filtro)) {
                echo json_encode(ResponseHttp::status400('Por favor ingrese el dato buscado'));
            } else {
                echo json_encode(FincaModel::getFilter($filtro));
                exit;
            }  
            exit;
        }    
    }

    /***************************************************Actualizar los datos de una finca*********************************************/
    final public function updateSave(string $endPoint)
    {        
               
        if ($this->getMethod() == 'post' && $this->getRoute() == $endPoint){            
            //Security::validateTokenJwt(Security::secretKey());
                        
            $numero      = $this->getParam()['numero'];
            $nombre      = $this->getParam()['nombre'];
            $tamano      = $this->getParam()['tamano'];
            $ubicacion   = $this->getParam()['ubicacion'];
            $propietario = $this->getParam()['propietario'];

            if (empty($numero) || empty($tamano) || empty($nombre) || empty($tamano) || empty($ubicacion) || empty($propietario)) {
                echo json_encode(ResponseHttp::status400('Ingrese los campos son requeridos'));
            } else {

                $validator = new Validator;
            
                $validation = $validator->validate($this->getParam(), [
                    'nombre'       => 'required|regex:/^[a-zA-Z ]+$/',
                    'tamano'       => 'required|numeric|between:1,100',
                    'ubicacion'    => 'required|regex:/^[a-zA-Z ]+$/',
                    'propietario'  => 'required|numeric|min:1|regex:/^[1234567890]+$/'
                ]); 

                if ($validation->fails()) {            
                    $errors = $validation->errors();            	
                    echo json_encode(ResponseHttp::status400($errors->all()[0]));
                } else {          
                    FincaModel::setNumero($numero);
                    FincaModel::setNombre($nombre);
                    FincaModel::setTamano($tamano);
                    FincaModel::setUbicacion($ubicacion);
                    FincaModel::setPropietario($propietario);                    
                    echo json_encode(FincaModel::updateSave());
                }
            }
            exit;
        }        
    }

}