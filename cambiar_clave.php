<?php  

include_once("includes/Funciones.php");

if(!verificarSesion()) {
  header('Location: index.php');
}

?>

<?php include_once("layouts/header_admin.php"); ?>

  <div class="container" style="margin-top: 100px" id="cambiarClave">
	  <div class="card card-primary contenedor">
	    <div class="card-header bg-primary">Cambiar clave</div>
	      <div class="card-body">
		      <div class="card-block">
	            <div class="form-group" name="form-group-usuario">
	              <label>Usuario</label>
	              <input type="text" class="form-control" placeholder="Ingrese usuario" v-model="usuario" readonly />
	            </div>
	            <div class="form-group" name="form-group-nueva-clave">
	              <label>Nueva clave</label>
	              <input type="password" class="form-control" placeholder="Ingrese nueva clave" v-model="nueva_clave" />     
	            </div>
	            <div class="form-group" name="form-group-clave">
	              <label>Clave</label>
	              <input type="password" class="form-control" placeholder="Ingrese clave" v-model="clave" />     
	            </div>	            
	           <div class="text-center">
	              <p class="lead">
	                <button type="submit" name="cambiar_clave" id="cambiar_clave" class="btn btn-primary boton-largo" @click="submitData">Guardar</button>
	              </p>
	            </div>
		      </div>
	    </div>
	  </div>
  </div>
  <script src="js/app/cambiarClave.js"></script>

<?php include_once("layouts/footer_admin.php"); ?>