<?php  

include_once("includes/Funciones.php");

if(!verificarSesion()) {
  header('Location: index.php');
}

?>

<?php include_once("layouts/header_admin.php"); ?>

<div class="container-fluid" style="margin-top: 100px">

	<h3 align="center">Estadísticas</h3>
	<br/>
	<?php include_once("grafico1.php"); ?>
	<br/>
	<?php include_once("grafico2.php"); ?>

</div>

<?php include_once("layouts/footer_admin.php"); ?>