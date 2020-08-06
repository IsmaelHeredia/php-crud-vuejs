<?php

include_once("Conexion.php");

class Seguridad {
  
   public function __construct(){

   }

   public function ingreso_usuario($usuario,$clave) {
      $response = false;
   	  $conexion = new Conexion();
      $conexion->abrir_conexion();
      $conn = $conexion->retornar_conexion();
      $sql = $conn->prepare('SELECT id FROM usuarios WHERE nombre = :usuario AND clave = :clave');
      $sql->execute(array('usuario' => $usuario, 'clave' => $clave));
      $resultado = $sql->fetchAll();
      $cantidad = count($resultado);
      if($cantidad >= 1) {
        $response = true;
      } else {
        $response = false;
      }
      $conexion->cerrar_conexion();
      return $response;
   }
   
   public function es_admin($usuario) {
      $response = false;
   	  $conexion = new Conexion();
      $conexion->abrir_conexion();
      $conn = $conexion->retornar_conexion();
      $sql = $conn->prepare('SELECT id_tipo FROM usuarios WHERE nombre = :usuario');
      $sql->execute(array('usuario' => $usuario));
      $resultado = $sql->fetch();
      $id_tipo = $resultado['id_tipo'];
      if($id_tipo=='1') {
        $response = true;
      } else {
        $response = false;
      }
      $conexion->cerrar_conexion();
      return $response;
   }
     	   
   public function __destruct(){
   }  
   
}

?>