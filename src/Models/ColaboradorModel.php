<?php

namespace App\Models;

use App\Config\ResponseHttp;
use App\Config\Security;
use App\DB\ConnectionDB;
use App\DB\Sql;

class ColaboradorModel extends ConnectionDB {

    //Propiedades de la base de datos
    private static int $numero;
    private static int $identificacion;
    private static string $nombre;
    private static int $telefono;    
    private static int $tarjeta;
    private static string $observaciones;
    private static string $tipo;   
    private static string $genero;    

    public function __construct(array $data)
    {
        self::$identificacion = $data['identificacion'];
        self::$nombre         = $data['nombre'];        
        self::$telefono       = $data['telefono'];
        self::$tarjeta        = $data['tarjeta']; 
        self::$observaciones  = $data['observaciones']; 
        self::$tipo           = $data['tipo']; 
        self::$genero         = $data['genero'];    
    }

    /************************Metodos Getter**************************/
    final public static function getNumero(){    return self::$numero;}
    final public static function getIdentificacion(){ return self::$identificacion;}
    final public static function getNombre(){    return self::$nombre;}
    final public static function getTelefono(){  return self::$telefono;} 
    final public static function getTarjeta(){   return self::$tarjeta;} 
    final public static function getObservaciones(){  return self::$observaciones;}
    final public static function getTipo(){    return self::$tipo;}      
    final public static function getGenero(){  return self::$genero;}       
    
    /**********************************Metodos Setter***********************************/
    final public static function setNumero(int $numero) {   self::$numero = $numero;}
    final public static function setIdentificacion(int $identificacion){  self::$identificacion = $identificacion;}
    final public static function setNombre(string $nombre){ self::$nombre = $nombre;}
    final public static function setTelefono(int $telefono){  self::$telefono = $telefono;}      
    final public static function setTarjeta(int $tarjeta){ self::$tarjeta = $tarjeta;}
    final public static function setObservaciones(string $observaciones){ self::$observaciones = $observaciones;}
    final public static function setTipo(string $tipo){ self::$tipo = $tipo;}
    final public static function setGenero(string $genero){   self::$genero = $genero;}    

     /**************************Obtener toda la lista de colaboradores**************************************/
    final public static function getAll()
    {
        try {
            $con = self::getConnection();
            $query = $con->prepare("SELECT * FROM colaborador_fex");
            $query->execute();
            $rs['data'] = $query->fetchAll(\PDO::FETCH_ASSOC);
            return $rs;
        } catch (\PDOException $e) {
            error_log("ColaboradorModel::getColaboradores -> ".$e);
            die(json_encode(ResponseHttp::status500('No se pueden obtener los datos')));
        }
    }

    /*******************************************Registrar colaborador************************************************/
    final public static function postSave()
    {
        if (Sql::exists("SELECT IDENTIFICACION FROM colaborador_fex WHERE IDENTIFICACION = :identificacion",":identificacion",self::getIdentificacion())) {  
            return ResponseHttp::status400('El colaborador ya esta registrado');
        }
        else {        

            try {
                $con = self::getConnection();
                $query1 = "INSERT INTO colaborador_fex (NOMBRE,IDENTIFICACION,TELEFONO,NUM_TARJETA,OBSERVACIONES,TIPO,GENERO) VALUES";
                $query2 = "(:nombre,:identificacion,:telefono,:tarjeta,:observaciones,:tipo,:genero)";
                $query = $con->prepare($query1 . $query2);
                $query->execute([
                    ':nombre'         => self::getNombre(),
                    ':identificacion' => self::getIdentificacion(),
                    ':telefono'       => self::getTelefono(),
                    ':tarjeta'        => self::getTarjeta(),                    
                    ':observaciones'  => self::getObservaciones(),
                    ':tipo'           => self::getTipo(),
                    ':genero'         => self::getGenero()          
                ]);
                if ($query->rowCount() > 0) {
                    return ResponseHttp::status200('Colaborador registrado exitosamente');
                } else {
                    return ResponseHttp::status500('No se puede registrar el colaborador');
                }
            } catch (\PDOException $e) {
                error_log('ColaboradorModel::post -> ' . $e);
                die(json_encode(ResponseHttp::status500()));
            }
        }
    }

    /**************************Consultar colaborador de acuerdo al filtro de nombre o número**************************************/
    final public static function getFilter(string $valorFiltro)
    {
        try {
            $con = self::getConnection();
            $query = $con->prepare("SELECT * FROM colaborador_fex WHERE NUMERO LIKE :filtro OR NOMBRE LIKE :filtro");
            $query->execute([
                ':filtro' =>  "%".$valorFiltro."%"
            ]);

            if ($query->rowCount() == 0) {
                return ResponseHttp::status400('El colaborador buscado no esta registrado');
            } else {
                $rs['data'] = $query->fetchAll(\PDO::FETCH_ASSOC);
                return $rs;
            }          
        } catch (\PDOException $e) {
            error_log("ColaboradorModel::getFilter -> ".$e);
            die(json_encode(ResponseHttp::status500('No se pueden obtener los datos del colaborador')));
        }
    }

    /**************************Consultar colaborador único según número**************************************/
    final public static function getOne()
    {
        try {
            $con = self::getConnection();
            $query = $con->prepare("SELECT * FROM colaborador_fex WHERE NUMERO = :numero");
            $query->execute([
                ':numero' => self::getNumero()
            ]);

            if ($query->rowCount() == 0) {
                return ResponseHttp::status400('El colaborador buscado no esta registrado');
            } else {
                $rs['data'] = $query->fetchAll(\PDO::FETCH_ASSOC);
                return $rs;
            }          
        } catch (\PDOException $e) {
            error_log("ColaboradorModel::getOne -> ".$e);
            die(json_encode(ResponseHttp::status500('No se pueden obtener los datos del usuario')));
        }
    }

    /******************************Actualizar la información del colaborador********************************/
    final public static function updateSave()
    {
        try {
            $con = self::getConnection();
            $query = $con->prepare("UPDATE colaborador_fex set NOMBRE = :nombre, IDENTIFICACION = :identificacion, TELEFONO = :telefono, 
            NUM_TARJETA = :tarjeta, OBSERVACIONES = :observaciones, TIPO = :tipo,  GENERO = :genero 
            where NUMERO = :numero");           
            $query->execute([
               ':numero'         => self::getNumero(),
               ':nombre'         => self::getNombre(),
               ':identificacion' => self::getIdentificacion(),
               ':tarjeta'        => self::getTarjeta(),
               ':telefono'       => self::getTelefono(),
               ':observaciones'  => self::getObservaciones(),                    
               ':tipo'           => self::getTipo(),
               ':genero'         => self::getGenero()
            ]);
            if ($query->rowCount() > 0) {
            return ResponseHttp::status200('El colaborador se ha actualizado exitosamente');
            } else {
            return ResponseHttp::status500('Error al actualizar los datos del colaborador');
            }
        } catch (\PDOException $e) {
            error_log("ColaboradorModel::updateSave -> " . $e);
            die(json_encode(ResponseHttp::status500()));
        }
    }
        
}

