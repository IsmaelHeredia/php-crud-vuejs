<?php  

include_once("includes/Funciones.php");

if(verificarSesion()) {
  header('Location: administracion.php');
}

?>

<?php include_once("layouts/header.php"); ?>

  <div class="container" id="ingreso">
	  <div class="card card-primary ingreso">
	    <div class="card-header bg-primary">Ingreso</div>
	      <div class="card-body">
		      <div class="card-block">
	            <div class="form-group" name="form-group-usuario">
	              <label>Usuario</label>
	              <input type="text" class="form-control" placeholder="Ingrese usuario" v-model="nombre" />
	            </div>
	            <div class="form-group" name="form-group-clave">
	              <label>Clave</label>
	              <input type="password" class="form-control" placeholder="Ingrese clave" v-model="clave" />     
	            </div>
	           <div class="text-center">
	              <p class="lead">
	                <button type="submit" name="ingresar" id="ingresar" class="btn btn-primary boton-largo" @click="submitData">Ingresar</button>
	              </p>
	            </div>
		      </div>
	    </div>
	  </div>
  </div>
  <script src="js/app/ingreso.js"></script>

<?php include_once("layouts/footer.php"); ?>