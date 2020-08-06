<?php

include_once("Seguridad.php");

function verificarSesion() {

	if(!isset($_SESSION)) {
	     session_start();
	}

	$seguridad = new Seguridad();

	if(isset($_SESSION["uid"])) {
		$contenido = $_SESSION["uid"];
		$contenido = base64_decode($contenido);

		$split = explode("@", $contenido);

		$usuario = $split[0];
		$clave = $split[1];

		if($seguridad->ingreso_usuario($usuario,$clave)) {
			return true;
		} else {
			return false;
		}
	} else {
		return false;
	}

}

function verificarSesionAdmin() {

	if(!isset($_SESSION)) {
	     session_start();
	}

	$seguridad = new Seguridad();

	if(isset($_SESSION["uid"])) {
		$contenido = $_SESSION["uid"];
		$contenido = base64_decode($contenido);

		$split = explode("@", $contenido);

		$usuario = $split[0];
		$clave = $split[1];

		if($seguridad->ingreso_usuario($usuario,$clave)) {
			if($seguridad->es_admin($usuario)) {
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	} else {
		return false;
	}

}

function cargarUsuarioSesion() {

	session_start();
	$contenido = $_SESSION["uid"];
	$contenido = base64_decode($contenido);

	$split = explode("@", $contenido);

	$usuario = $split[0];
	
	return $usuario;
}

function fecha_actual() {
  date_default_timezone_set("America/Argentina/Cordoba");
  $fecha = date("d/m/Y", time());
  return $fecha;
}

?>