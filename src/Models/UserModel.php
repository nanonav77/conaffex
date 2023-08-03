<?php

namespace App\Models;

use App\Config\ResponseHttp;
use App\Config\Security;
use App\DB\ConnectionDB;
use App\DB\Sql;

class UserModel extends ConnectionDB {

    //Propiedades de la base de datos
    private static int $numero;
    private static int $identificacion;
    private static string $nombre;
    private static string $correo;    
    private static string $contrasena;
    private static int    $tipo_usuario;
    private static int    $estado;   
    private static string  $IDToken;    

    public function __construct(array $data)
    {
        self::$numero         = $data['numero'];
        self::$identificacion = $data['identificacion'];
        self::$nombre         = $data['nombre'];        
        self::$correo         = $data['correo'];
        self::$contrasena     = $data['contrasena']; 
        self::$tipo_usuario   = $data['tipo_usuario']; 
        self::$estado         = $data['estado'];    
    }

    /************************Metodos Getter**************************/
    final public static function getNumero(){    return self::$numero;}
    final public static function getIdentificacion(){ return self::$identificacion;}
    final public static function getNombre(){    return self::$nombre;}
    final public static function getEmail(){     return self::$correo;} 
    final public static function getPass(){     return self::$contrasena;} 
    final public static function getRol(){  return self::$tipo_usuario;}
    final public static function getEstado(){    return self::$estado;}      
    final public static function getIDToken(){  return self::$IDToken;}       
    
    /**********************************Metodos Setter***********************************/
    final public static function setNumero(int $numero) {   self::$numero = $numero;}
    final public static function setIdentificacion(int $identificacion){  self::$identificacion = $identificacion;}
    final public static function setNombre(string $nombre){ self::$nombre = $nombre;}
    final public static function setEmail(string $correo){   self::$correo = $correo;}      
    final public static function setPass(string $pass){ self::$contrasena = $pass;}
    final public static function setRol(int $rol){ self::$tipo_usuario = $rol;}
    final public static function setEstado(int $estado){ self::$estado = $estado;}
    final public static function setIDToken(string $IDToken){   self::$IDToken = $IDToken;}    

     /**************************Consultar usuario según nombre de usuario**************************************/
    final public static function getUsers()
    {
        try {
            $con = self::getConnection();
            $query = $con->prepare("SELECT * FROM usuarios_fex");
            $query->execute();
            $rs['data'] = $query->fetchAll(\PDO::FETCH_ASSOC);
            return $rs;
        } catch (\PDOException $e) {
            error_log("UserModel::getUsers -> ".$e);
            die(json_encode(ResponseHttp::status500('No se pueden obtener los datos')));
        }
    }
        
}