<?php

class Conexion {

	private $conexion;

	public function __construct() {
		$this->conexion = "";
	}

	public function abrir_conexion() {

		$host = "localhost";
		$usuario = "root";
		$clave = "";
		$bd = "sistemaV2";

		$this->conexion = new PDO("mysql:host=".$host.";dbname=".$bd.";charset=utf8",$usuario,$clave);
		$this->conexion->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		$this->conexion->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
	}

	public function retornar_conexion() {
		return $this->conexion;
	}

	public function cerrar_conexion() {
		$this->conexion = null;
	}

	public function __destruct() {
		$this->conexion = "";
	}

}

?>