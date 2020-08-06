<?php  

include_once("includes/Funciones.php");

if(verificarSesion()) {
  if(!verificarSesionAdmin()) {
    header('Location: administracion.php');
  }
} else {
  header('Location: index.php');
}

?>

<?php include_once("layouts/header_admin.php"); ?>

  <div class="container" id="crudUsuarios">
   <br />
   <h3 align="center">Usuarios</h3>
   <br />
   <div class="card">
    <div class="card-header">
     <div class="row">
      <div class="col-md-6">
       <h3 class="card-title">Lista de usuarios</h3>
      </div>
      <div class="col-md-6" align="right">
       <input type="button" class="btn btn-success btn-xs" @click="openModel" value="Agregar" />
      </div>
     </div>
    </div>
    <div class="card-body">
     <div class="table-responsive">
      <table class="table table-bordered table-striped">
       <tr>
        <th>Nombre</th>
        <th>Tipo</th>
        <th>Fecha</th>
        <th>Opción</th>
       </tr>
       <tr v-for="usuario in usuarios">
        <td>{{ usuario.nombre }}</td>
        <td>{{ usuario.tipo }}</td>
        <td>{{ usuario.fecha_registro }}</td>
        <td>
          <button type="button" name="edit" class="btn btn-primary btn-xs edit" @click="fetchData(usuario.id)">Editar</button>
          <button type="button" name="delete" class="btn btn-danger btn-xs delete" @click="deleteData(usuario.id)">Borrar</button>
        </td>
       </tr>
      </table>
     </div>
    </div>
   </div>
   <div v-if="model_usuario">
    <transition name="model">
     <div class="modal-mask">
      <div class="modal-wrapper">
       <div class="modal-dialog">
        <div class="modal-content">
         <div class="modal-header">
	       <h4 class="modal-title">{{ modal_title }}</h4>
	       <button type="button" class="close" @click="model_usuario=false">
	         <span aria-hidden="true">&times;</span>
	       </button>
         </div>
         <div class="modal-body">
          <div class="form-group">
           <label>Ingrese nombre</label>
           <input type="text" class="form-control" placeholder="Ingrese nombre" v-model="nombre" :disabled="bloquear_nombre" />
          </div>
          <div class="form-group">
           <label>Ingrese clave</label>
           <input type="password" class="form-control" placeholder="Ingrese clave" v-model="clave" :disabled="bloquear_clave" />
          </div>
          <div class="form-group">
           <label>Seleccione tipo de usuario</label>
            <select class="form-control" v-model="id_tipo">
              <option value="">Seleccione un tipo</option>
              <option v-for="tipo_usuario in tipos_usuarios" v-bind:value="tipo_usuario.id">
                {{ tipo_usuario.nombre }}
              </option>
            </select>
          </div>
          <br />
          <div align="center">
           <input type="hidden" v-model="id_usuario" />
           <input type="button" class="btn btn-success btn-xs" value="Guardar" @click="submitData"/>
          </div>
         </div>
        </div>
       </div>
      </div>
     </div>
    </transition>
   </div>
  </div>
  <script src="js/app/usuarios.js"></script>

<?php include_once("layouts/footer_admin.php"); ?>