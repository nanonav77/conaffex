<?php

namespace App\Models;

use App\Config\ResponseHttp;
use App\Config\Security;
use App\DB\ConnectionDB;
use App\DB\Sql;

class FincaModel extends ConnectionDB {

    //Propiedades de la base de datos
    private static int $numero;
    private static string $nombre;
    private static float $tamano;    
    private static string $ubicacion;  
    private static int $propietario;    

    public function __construct(array $data)
    {
        self::$nombre      = $data['nombre'];        
        self::$tamano      = $data['tamano'];
        self::$ubicacion   = $data['ubicacion']; 
        self::$propietario = $data['propietario'];   
    }

    /************************Metodos Getter**************************/
    final public static function getNumero(){    return self::$numero;}
    final public static function getNombre(){    return self::$nombre;}
    final public static function getTamano(){    return self::$tamano;}
    final public static function getUbicacion(){ return self::$ubicacion;} 
    final public static function getPropietario(){ return self::$propietario;}    
    
    /**********************************Metodos Setter***********************************/
    final public static function setNumero(int $numero) {   self::$numero = $numero;}
    final public static function setNombre(string $nombre){  self::$nombre = $nombre;}
    final public static function setTamano(float  $tamano){ self::$tamano = $tamano;}
    final public static function setUbicacion(string $ubicacion){  self::$ubicacion = $ubicacion;}      
    final public static function setPropietario(int $propietario){ self::$propietario = $propietario;}
    
    /**************************Obtener toda la lista de fincas**************************************/
    final public static function getAll()
    {
        try {
            $con = self::getConnection();
            $query = $con->prepare("SELECT A.*, B.IDENTIFICACION, B.NOMBRE AS PROPIETARIO FROM FINCAS_FEX AS A INNER JOIN USUARIOS_FEX AS B ON A.NUM_PROPIETARIO = B.NUMERO ORDER BY A.NUMERO ASC");
            $query->execute();
            $rs['data'] = $query->fetchAll(\PDO::FETCH_ASSOC);
            return $rs;
        } catch (\PDOException $e) {
            error_log("FincaModel::getAll -> ".$e);
            die(json_encode(ResponseHttp::status500('No se pueden obtener los datos')));
        }
    }

    /**************************Consultar finca de acuerdo al filtro de nombre o número**************************************/
    final public static function getFilter(string $valorFiltro)
    {
        try {
            $con = self::getConnection();
            $query = $con->prepare("SELECT A.*, B.IDENTIFICACION, B.NOMBRE AS PROPIETARIO FROM FINCAS_FEX AS A INNER JOIN USUARIOS_FEX AS B ON A.NUM_PROPIETARIO = B.NUMERO WHERE A.NUMERO LIKE :filtro OR A.NOMBRE LIKE :filtro ORDER BY A.NUMERO ASC");
            $query->execute([
                ':filtro' =>  "%".$valorFiltro."%"
            ]);

            if ($query->rowCount() == 0) {
                return ResponseHttp::status400('La finca buscada no esta registrada');
            } else {
                $rs['data'] = $query->fetchAll(\PDO::FETCH_ASSOC);
                return $rs;
            }          
        } catch (\PDOException $e) {
            error_log("FincaModel::getFilter -> ".$e);
            die(json_encode(ResponseHttp::status500('No se pueden obtener los datos de la finca')));
        }
    }

    /**************************Consultar finca única según número**************************************/
    final public static function getOne()
    {
        try {
            $con = self::getConnection();
            $query = $con->prepare("SELECT A.*, B.IDENTIFICACION, B.NOMBRE AS PROPIETARIO FROM FINCAS_FEX AS A INNER JOIN USUARIOS_FEX AS B ON A.NUM_PROPIETARIO = B.NUMERO WHERE A.NUMERO = :numero");
            $query->execute([
                ':numero' => self::getNumero()
            ]);

            if ($query->rowCount() == 0) {
                return ResponseHttp::status400('La finca buscada no esta registrada');
            } else {
                $rs['data'] = $query->fetchAll(\PDO::FETCH_ASSOC);
                return $rs;
            }          
        } catch (\PDOException $e) {
            error_log("FincaModel::getOne -> ".$e);
            die(json_encode(ResponseHttp::status500('No se pueden obtener los datos de la finca')));
        }
    }

    /******************************Actualizar la información de la finca********************************/
    final public static function updateSave()
    {
        try {
            $con = self::getConnection();
            $query = $con->prepare("UPDATE fincas_fex set NOMBRE = :nombre, TAMANO = :tamano, UBICACION = :ubicacion, 
            NUM_PROPIETARIO = :propietario where NUMERO = :numero");           
            $query->execute([
               ':numero'         => self::getNumero(),
               ':nombre'         => self::getNombre(),
               ':tamano'         => self::getTamano(),
               ':ubicacion'      => self::getUbicacion(),
               ':propietario'    => self::getPropietario()
            ]);
            if ($query->rowCount() > 0) {
            return ResponseHttp::status200('La finca se ha actualizado exitosamente');
            } else {
            return ResponseHttp::status500('Error al actualizar los datos de la finca');
            }
        } catch (\PDOException $e) {
            error_log("FincaModel::updateSave -> " . $e);
            die(json_encode(ResponseHttp::status500()));
        }
    }

    /*******************************************Registrar una finca************************************************/
    final public static function postSave()
    {
        if (Sql::exists("SELECT NOMBRE FROM fincas_fex WHERE NOMBRE = :nombre",":nombre",self::getNombre())) {  
            return ResponseHttp::status400('La finca ya se encuentra registrada');
        }
        else {        

            try {
                $con = self::getConnection();
                $query1 = "INSERT INTO fincas_fex (NOMBRE,TAMANO,UBICACION,NUM_PROPIETARIO) VALUES";
                $query2 = "(:nombre,:tamano,:ubicacion,:propietario)";
                $query = $con->prepare($query1 . $query2);
                $query->execute([
                    ':nombre'      => self::getNombre(),
                    ':tamano'      => self::getTamano(),
                    ':ubicacion'   => self::getUbicacion(),
                    ':propietario' => self::getPropietario()          
                ]);
                if ($query->rowCount() > 0) {
                    return ResponseHttp::status200('Finca registrada exitosamente');
                } else {
                    return ResponseHttp::status500('No se puede registrar la finca');
                }
            } catch (\PDOException $e) {
                error_log('FincaModel::postSave -> ' . $e);
                die(json_encode(ResponseHttp::status500()));
            }
        }
    }

}

