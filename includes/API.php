<?php

include_once("Conexion.php");
include_once("Funciones.php");
include_once("Seguridad.php");

header("Access-Control-Allow-Origin: *");  
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS");
header("Access-Control-Max-Age: 1000");
header("Access-Control-Allow-Headers: Content-Type, Content-Range, Content-Disposition, Content-Description");

$rest_json = file_get_contents("php://input");
$_POST = json_decode($rest_json, true);

if( isset($_POST["tipo"]) && !empty( isset($_POST["tipo"]) ) ) {

	$tipo = $_POST["tipo"];

	$control_usuario = false;
	$control_admin = false;

	if(verificarSesion()) {
		$control_usuario = true;
	}

	if(verificarSesionAdmin()) {
		$control_admin = true;
	}	

	// Ingreso

	if($tipo == "ingresoUsuario") {
		$usuario = $_POST["usuario"];
		$clave = $_POST["clave"];
		ingresoUsuario($usuario,$clave);
	}

	// Admin

	if($control_usuario == true) {
		if($tipo == "recibirUsuarioSesion") {
			recibirUsuarioSesion();
		} 
		elseif($tipo == "cerrarSesion") { 
			cerrarSesion();
		}
	}

	// CRUD para usuarios normales

	if($control_usuario == true) {
		if($tipo == "listarProveedores") {
			listarProveedores();
		}
		elseif($tipo == "cargarProveedor") {
			$id = $_POST["id"];
			if(is_numeric($id)) {
				cargarProveedor($id);
			}
		}
		elseif($tipo == "agregarProveedor") {
			$nombre = $_POST["nombre"];
			$direccion = $_POST["direccion"];
			$telefono = $_POST["telefono"];
			agregarProveedor($nombre,$direccion,$telefono);
		}
		elseif($tipo == "editarProveedor") {
			$id = $_POST["id"];
			$nombre = $_POST["nombre"];
			$direccion = $_POST["direccion"];
			$telefono = $_POST["telefono"];
			editarProveedor($id,$nombre,$direccion,$telefono);
		}
		elseif($tipo == "borrarProveedor") {
			$id = $_POST["id"];
			borrarProveedor($id);
		}
		elseif($tipo == "listarProductos") {
			listarProductos();
		}
		elseif($tipo == "cargarProducto") {
			$id = $_POST["id"];
			if(is_numeric($id)) {
				cargarProducto($id);
			}
		}
		elseif($tipo == "agregarProducto") {
			$nombre = $_POST["nombre"];
			$descripcion = $_POST["descripcion"];
			$precio = $_POST["precio"];
			$id_proveedor = $_POST["id_proveedor"];
			agregarProducto($nombre,$descripcion,$precio,$id_proveedor);
			
		}
		elseif($tipo == "editarProducto") {
			$id = $_POST["id"];
			$nombre = $_POST["nombre"];
			$descripcion = $_POST["descripcion"];
			$precio = $_POST["precio"];
			$id_proveedor = $_POST["id_proveedor"];
			editarProducto($id,$nombre,$descripcion,$precio,$id_proveedor);		
		}
		elseif($tipo == "borrarProducto") {
			$id = $_POST["id"];
			borrarProducto($id);		
		}
	}

	// CRUD solo para administradores

	if($control_admin == true) {
		if($tipo == "listarUsuarios") {
			listarUsuarios();
		}
		elseif($tipo == "cargarUsuario") {
			$id = $_POST["id"];
			if(is_numeric($id)) {
				cargarUsuario($id);
			}
		}
		elseif($tipo == "agregarUsuario") {
			$nombre = $_POST["nombre"];
			$clave = $_POST["clave"];
			$id_tipo = $_POST["id_tipo"];
			agregarUsuario($nombre,$clave,$id_tipo);
		}
		elseif($tipo == "editarUsuario") {
			$id = $_POST["id"];
			$id_tipo = $_POST["id_tipo"];
			editarUsuario($id,$id_tipo);
		}
		elseif($tipo == "borrarUsuario") {
			$id = $_POST["id"];
			borrarUsuario($id);		
		}
		elseif($tipo == "listarTiposUsuarios") {
			listarTiposUsuarios();
		}
	}

	// Cuenta

	if($control_usuario == true) {
		if($tipo == "cambiarUsuario") {
			$usuario = $_POST["usuario"];
			$nuevo_usuario = $_POST["nuevo_usuario"];
			$clave = $_POST["clave"];
			cambiarUsuario($usuario,$nuevo_usuario,$clave);
			cerrarSesion();
		}
		elseif($tipo == "cambiarClave") {
			$usuario = $_POST["usuario"];
			$nueva_clave = $_POST["nueva_clave"];
			$clave = $_POST["clave"];
			cambiarClave($usuario,$nueva_clave,$clave);
			cerrarSesion();
		}
	}
}

// Controles de acceso

function ingresoUsuario($usuario,$clave) {

	$clave = md5($clave);

	$data = array();

	$estado = false;

	$seguridad = new Seguridad(); 

	if($seguridad->ingreso_usuario($usuario,$clave)) {
		$estado = true;

		if(!isset($_SESSION)) {
		     session_start();
		}

		$_SESSION["uid"]= base64_encode($usuario."@".$clave);
	}
	
	$data['estado'] = $estado;

	echo json_encode($data);
	exit;
}

function recibirUsuarioSesion() {

	if(!isset($_SESSION)) {
	     session_start();
	}
	
	$contenido = $_SESSION["uid"];
	$contenido = base64_decode($contenido);

	$split = explode("@", $contenido);

	$usuario = $split[0];
	$clave = $split[1];

	$data = array();

	$data['estado'] = true;
	$data['nombreUsuario'] = $usuario;
	
	echo json_encode($data);
	exit;
}

function cerrarSesion() {
	if(!isset($_SESSION)) {
	     session_start();
	}
	session_destroy();
	session_unset();
}

// Proveedores

function listarProveedores() {
	$data = array();
	$conexion = new Conexion();
	$conexion->abrir_conexion();
	$conn = $conexion->retornar_conexion();

	$sql = $conn->prepare("SELECT id,nombre,direccion,telefono,fecha_registro FROM proveedores");
	$sql->execute();
	$resultado = $sql->fetchAll();
	foreach($resultado as $fila) {
		$data["proveedores"][] = $fila;
	}
	$conexion->cerrar_conexion();
	$data["success"] = true;
	echo json_encode($data);
	exit;
}

function cargarProveedor($id) {
	$data = array();
	$conexion = new Conexion();
	$conexion->abrir_conexion();
	$conn = $conexion->retornar_conexion();
	$sql = $conn->prepare("SELECT id,nombre,direccion,telefono,fecha_registro FROM proveedores WHERE id = :id");
	$sql->bindParam(":id",$id,PDO::PARAM_INT);
	$sql->execute();
	$resultado = $sql->fetch();
	$data["proveedor"] = $resultado;
	$conexion->cerrar_conexion();
	$data["success"] = true;
	echo json_encode($data);
	exit;
}

function agregarProveedor($nombre,$direccion,$telefono) {
	$data = array();
	$estado = 0;
	if(!comprobarExistenciaProveedorCrear($nombre)) {
		$fecha_registro = fecha_actual();
		$conexion = new Conexion();
		$conexion->abrir_conexion();
		$conn = $conexion->retornar_conexion();
		$sql = $conn->prepare("INSERT INTO proveedores(nombre,direccion,telefono,fecha_registro) VALUES(?,?,?,?)");
		$sql->execute([$nombre, $direccion, $telefono, $fecha_registro]);
		$conexion->cerrar_conexion();
		$estado = 1;
	}
	$data["estado"] = $estado;
	echo json_encode($data);
	exit;
}

function editarProveedor($id,$nombre,$direccion,$telefono) {
	$data = array();
	$estado = 0;
	if(!comprobarExistenciaProveedorEditar($id,$nombre)) {
		$conexion = new Conexion();
		$conexion->abrir_conexion();
		$conn = $conexion->retornar_conexion();
		$sql = $conn->prepare("UPDATE proveedores SET nombre = ?, direccion = ?, telefono = ? WHERE id = ?");
		$sql->execute([$nombre, $direccion, $telefono, $id]);
		$conexion->cerrar_conexion();
		$estado = 1;
	}
	$data["estado"] = $estado;
	echo json_encode($data);
	exit;
}

function borrarProveedor($id) {
	$data = array();
	$conexion = new Conexion();
	$conexion->abrir_conexion();
	$conn = $conexion->retornar_conexion();
	$sql = $conn->prepare("DELETE FROM proveedores WHERE id = ?");
	$sql->execute([$id]);
	$conexion->cerrar_conexion();
	$data["estado"] = 1;
	echo json_encode($data);
	exit;
}

// Productos

function listarProductos() {
	$data = array();
	$conexion = new Conexion();
	$conexion->abrir_conexion();
	$conn = $conexion->retornar_conexion();

	$sql = $conn->prepare("SELECT prod.id,prod.nombre,prod.descripcion,prod.precio,prod.id_proveedor,prov.nombre AS nombre_proveedor,prod.fecha_registro FROM productos prod, proveedores prov WHERE prod.id_proveedor = prov.id");
	$sql->execute();
	$resultado = $sql->fetchAll();
	foreach($resultado as $fila) {
		$data["productos"][] = $fila;
	}
	$conexion->cerrar_conexion();
	$data["success"] = true;
	echo json_encode($data);
	exit;
}

function cargarProducto($id) {
	$data = array();
	$conexion = new Conexion();
	$conexion->abrir_conexion();
	$conn = $conexion->retornar_conexion();
	$sql = $conn->prepare("SELECT prod.id,prod.nombre,prod.descripcion,prod.precio,prod.id_proveedor,prod.fecha_registro,prov.nombre AS nombre_empresa FROM productos prod, proveedores prov WHERE prod.id_proveedor = prov.id AND prod.id = :id");
	$sql->bindParam(":id",$id,PDO::PARAM_INT);
	$sql->execute();
	$resultado = $sql->fetch();
	$data["producto"] = $resultado;
	$conexion->cerrar_conexion();
	$data["success"] = true;
	echo json_encode($data);
	exit;
}

function agregarProducto($nombre,$descripcion,$precio,$id_proveedor) {
    $data = array();
	$estado = 0;
	if(!comprobarExistenciaProductoCrear($nombre)) {
		$fecha_registro = fecha_actual();
		$conexion = new Conexion();
		$conexion->abrir_conexion();
		$conn = $conexion->retornar_conexion();
		$sql = $conn->prepare("INSERT INTO productos(nombre,descripcion,precio,id_proveedor,fecha_registro) VALUES(?,?,?,?,?)");
		$sql->execute([$nombre, $descripcion, $precio, $id_proveedor, $fecha_registro]);
		$conexion->cerrar_conexion();
		$estado = 1;
	}
	$data["estado"] = $estado;
	echo json_encode($data);
	exit;
}

function editarProducto($id,$nombre,$descripcion,$precio,$id_proveedor) {
	$data = array();
	$estado = 0;
	if(!comprobarExistenciaProductoEditar($id,$nombre)) { 
		$conexion = new Conexion();
		$conexion->abrir_conexion();
		$conn = $conexion->retornar_conexion();
		$sql = $conn->prepare("UPDATE productos SET nombre = ?, descripcion = ?, precio = ?, id_proveedor = ? WHERE id = ?");
		$sql->execute([$nombre, $descripcion, $precio, $id_proveedor, $id]);
		$conexion->cerrar_conexion();
		$estado = 1;
	}
	$data["estado"] = $estado;
	echo json_encode($data);
	exit;
}

function borrarProducto($id) {
	$data = array();
	$conexion = new Conexion();
	$conexion->abrir_conexion();
	$conn = $conexion->retornar_conexion();
	$sql = $conn->prepare("DELETE FROM productos WHERE id = ?");
	$sql->execute([$id]);
	$conexion->cerrar_conexion();
	$data["estado"] = 1;
	echo json_encode($data);
	exit;
}

// Usuarios

function listarUsuarios() {
	$data = array();
	$conexion = new Conexion();
	$conexion->abrir_conexion();
	$conn = $conexion->retornar_conexion();

	$sql = $conn->prepare("SELECT us.id,us.nombre,us.clave,us.id_tipo,tu.nombre AS tipo,us.fecha_registro FROM usuarios us, tipos_usuarios tu WHERE us.id_tipo = tu.id");
	$sql->execute();
	$resultado = $sql->fetchAll();
	foreach($resultado as $fila) {
		$data["usuarios"][] = $fila;
	}
	$conexion->cerrar_conexion();
	$data["success"] = true;
	echo json_encode($data);
	exit;
}

function cargarUsuario($id) {
	$data = array();
	$conexion = new Conexion();
	$conexion->abrir_conexion();
	$conn = $conexion->retornar_conexion();
	$sql = $conn->prepare("SELECT us.id,us.nombre,us.clave,us.id_tipo,tu.nombre AS tipo,us.fecha_registro FROM usuarios us, tipos_usuarios tu WHERE us.id_tipo = tu.id AND us.id = :id");
	$sql->bindParam(":id",$id,PDO::PARAM_INT);
	$sql->execute();
	$resultado = $sql->fetch();
	$data["usuario"] = $resultado;
	$conexion->cerrar_conexion();
	$data["success"] = true;
	echo json_encode($data);
	exit;
}

function agregarUsuario($nombre,$clave,$id_tipo) {
	$data = array();
	$estado = 0;
	if(!comprobarExistenciaUsuarioCrear($nombre)) {
		$fecha_registro = fecha_actual();
		$conexion = new Conexion();
		$conexion->abrir_conexion();
		$conn = $conexion->retornar_conexion();
		$sql = $conn->prepare("INSERT INTO usuarios(nombre,clave,id_tipo,fecha_registro) VALUES(?,?,?,?)");
		$sql->execute([$nombre, md5($clave), $id_tipo, $fecha_registro]);
		$conexion->cerrar_conexion();
		$estado = 1;
	}
	$data["estado"] = $estado;
	echo json_encode($data);
	exit;
}

function editarUsuario($id,$id_tipo) {
	$data = array();
	$conexion = new Conexion();
	$conexion->abrir_conexion();
	$conn = $conexion->retornar_conexion();
	$sql = $conn->prepare("UPDATE usuarios SET id_tipo = ? WHERE id = ?");
	$sql->execute([$id_tipo, $id]);
	$conexion->cerrar_conexion();
	$data["estado"] = 1;
	echo json_encode($data);
	exit;
}

function borrarUsuario($id) {
	$data = array();
	$conexion = new Conexion();
	$conexion->abrir_conexion();
	$conn = $conexion->retornar_conexion();
	$sql = $conn->prepare("DELETE FROM usuarios WHERE id = ?");
	$sql->execute([$id]);
	$conexion->cerrar_conexion();
	$data["estado"] = 1;
	echo json_encode($data);
	exit;
}

// Tipos de usuarios

function listarTiposUsuarios() {
	$data = array();
	$conexion = new Conexion();
	$conexion->abrir_conexion();
	$conn = $conexion->retornar_conexion();
	$sql = $conn->prepare("SELECT tu.id,tu.nombre FROM tipos_usuarios tu");
	$sql->execute();
	$resultado = $sql->fetchAll();
	foreach($resultado as $fila) {
		$data["tipos_usuarios"][] = $fila;
	}
	$conexion->cerrar_conexion();
	$data["success"] = true;
	echo json_encode($data);
	exit;
}

// Cuenta

function cambiarUsuario($usuario,$nuevo_usuario,$clave) {
    $data = array();
	$estado = 0;
	if(!comprobarExistenciaUsuarioCrear($nuevo_usuario)) {
		$seguridad = new Seguridad(); 
		if($seguridad->ingreso_usuario($usuario,md5($clave))) {
		    $conexion = new Conexion();
		    $conexion->abrir_conexion();
		    $conn = $conexion->retornar_conexion();
		    $sql = $conn->prepare('UPDATE usuarios SET nombre = ? WHERE nombre = ?');
		    $sql->execute([$nuevo_usuario,$usuario]);
		    $conexion->cerrar_conexion();
		    $estado = 1;
		} else {
			$estado = 2;
		}
	}
	$data["estado"] = $estado;
	echo json_encode($data);
	exit;
}

function cambiarClave($usuario,$nueva_clave,$clave) {
	$estado = 0;
	$seguridad = new Seguridad(); 
	if($seguridad->ingreso_usuario($usuario,md5($clave))) {
		$data = array();
	    $conexion = new Conexion();
	    $conexion->abrir_conexion();
	    $conn = $conexion->retornar_conexion();
	    $sql = $conn->prepare('UPDATE usuarios SET clave = ? WHERE nombre = ?');
	    $sql->execute([md5($nueva_clave),$usuario]);
	    $conexion->cerrar_conexion();
	    $estado = 1;
	}
	$data["estado"] = $estado;
	echo json_encode($data);
	exit;
}

// Funciones externas

function comprobarExistenciaProductoCrear($nombre) {
  $response = false;
  $conexion = new Conexion();
  $conexion->abrir_conexion();
  $conn = $conexion->retornar_conexion();
  $sql = $conn->prepare('SELECT * FROM productos WHERE nombre = ?');
  $sql->execute([$nombre]);
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

function comprobarExistenciaProductoEditar($id,$nombre) {
  $response = false;
  $conexion = new Conexion();
  $conexion->abrir_conexion();
  $conn = $conexion->retornar_conexion();
  $sql = $conn->prepare('SELECT * FROM productos WHERE nombre = ? AND id != ?');
  $sql->execute([$nombre,$id]);
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

function comprobarExistenciaProveedorCrear($nombre) {
  $response = false;
  $conexion = new Conexion();
  $conexion->abrir_conexion();
  $conn = $conexion->retornar_conexion();
  $sql = $conn->prepare('SELECT * FROM proveedores WHERE nombre = ?');
  $sql->execute([$nombre]);
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

function comprobarExistenciaProveedorEditar($id,$nombre) {
  $response = false;
  $conexion = new Conexion();
  $conexion->abrir_conexion();
  $conn = $conexion->retornar_conexion();
  $sql = $conn->prepare('SELECT * FROM proveedores WHERE nombre = ? AND id != ?');
  $sql->execute([$nombre,$id]);
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

function comprobarExistenciaUsuarioCrear($nombre) {
  $response = false;
  $conexion = new Conexion();
  $conexion->abrir_conexion();
  $conn = $conexion->retornar_conexion();
  $sql = $conn->prepare('SELECT * FROM usuarios WHERE nombre = ?');
  $sql->execute([$nombre]);
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

function comprobarExistenciaUsuarioEditar($id,$nombre) {
  $response = false;
  $conexion = new Conexion();
  $conexion->abrir_conexion();
  $conn = $conexion->retornar_conexion();
  $sql = $conn->prepare('SELECT * FROM usuarios WHERE nombre = ? AND id != ?');
  $sql->execute([$nombre,$id]);
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

function cargarIdUsuario($nombre) {
	$conexion = new Conexion();
	$conexion->abrir_conexion();
	$conn = $conexion->retornar_conexion();
	$sql = $conn->prepare("SELECT id FROM usuarios WHERE nombre = :nombre");
	$sql->bindParam(":nombre",$nombre,PDO::PARAM_STR);
	$sql->execute();
	$resultado = $sql->fetch();
	$id = $resultado["id"];
	$conexion->cerrar_conexion();
	return $id;
}

?>