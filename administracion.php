<?php  

include_once("includes/Funciones.php");

if(!verificarSesion()) {
  header('Location: index.php');
}

?>

<?php include_once("layouts/header_admin.php"); ?>

<div class="container-fluid" style="margin-top: 100px" id="datosAdmin">
	<h1 align="center">Bienvenido <span id="bienvenidaNombreUsuario"></span></h1>
</div>

<?php include_once("layouts/footer_admin.php"); ?>