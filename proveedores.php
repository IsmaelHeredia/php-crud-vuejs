<?php  

include_once("includes/Funciones.php");

if(!verificarSesion()) {
  header('Location: index.php');
}

?>

<?php include_once("layouts/header_admin.php"); ?>

  <div class="container" id="crudProveedores">
   <br />
   <h3 align="center">Proveedores</h3>
   <br />
   <div class="card">
    <div class="card-header">
     <div class="row">
      <div class="col-md-6">
       <h3 class="card-title">Lista de proveedores</h3>
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
        <th>Dirección</th>
        <th>Teléfono</th>
        <th>Fecha</th>
        <th>Opción</th>
       </tr>
       <tr v-for="proveedor in proveedores">
        <td>{{ proveedor.nombre }}</td>
        <td>{{ proveedor.direccion }}</td>
        <td>{{ proveedor.telefono }}</td>
        <td>{{ proveedor.fecha_registro }}</td>
        <td>
          <button type="button" name="edit" class="btn btn-primary btn-xs edit" @click="fetchData(proveedor.id)">Editar</button>
          <button type="button" name="delete" class="btn btn-danger btn-xs delete" @click="deleteData(proveedor.id)">Borrar</button>
        </td>
       </tr>
      </table>
     </div>
    </div>
   </div>
   <div v-if="model_proveedor">
    <transition name="model">
     <div class="modal-mask">
      <div class="modal-wrapper">
       <div class="modal-dialog">
        <div class="modal-content">
         <div class="modal-header">
	       <h4 class="modal-title">{{ modal_title }}</h4>
	       <button type="button" class="close" @click="model_proveedor=false">
	         <span aria-hidden="true">&times;</span>
	       </button>
         </div>
         <div class="modal-body">
          <div class="form-group">
           <label>Ingrese nombre</label>
           <input type="text" class="form-control" placeholder="Ingrese nombre" v-model="nombre" />
          </div>
          <div class="form-group">
           <label>Ingrese dirección</label>
           <input type="text" class="form-control" placeholder="Ingrese dirección" v-model="direccion" />
          </div>
          <div class="form-group">
           <label>Ingrese teléfono</label>
           <input type="text" class="form-control" placeholder="Ingrese teléfono" v-model="telefono" />
          </div>
          <br />
          <div align="center">
           <input type="hidden" v-model="id_proveedor" />
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
  <script src="js/app/proveedores.js"></script>

<?php include_once("layouts/footer_admin.php"); ?>