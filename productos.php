<?php  

include_once("includes/Funciones.php");

if(!verificarSesion()) {
  header('Location: index.php');
}

?>

<?php include_once("layouts/header_admin.php"); ?>

  <div class="container" id="crudProductos">
   <br />
   <h3 align="center">Productos</h3>
   <br />
   <div class="card">
    <div class="card-header">
     <div class="row">
      <div class="col-md-6">
       <h3 class="card-title">Lista de productos</h3>
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
        <th>Descripción</th>
        <th>Precio</th>
        <th>Proveedor</th>
        <th>Fecha</th>
        <th>Opción</th>
       </tr>
       <tr v-for="producto in productos">
        <td>{{ producto.nombre }}</td>
        <td>{{ producto.descripcion }}</td>
        <td>{{ producto.precio }}</td>
        <td>{{ producto.nombre_proveedor }}</td>
        <td>{{ producto.fecha_registro }}</td>
        <td>
          <button type="button" name="edit" class="btn btn-primary btn-xs edit" @click="fetchData(producto.id)">Editar</button>
          <button type="button" name="delete" class="btn btn-danger btn-xs delete" @click="deleteData(producto.id)">Borrar</button>
        </td>
       </tr>
      </table>
     </div>
    </div>
   </div>
   <div v-if="model_producto">
    <transition name="model">
     <div class="modal-mask">
      <div class="modal-wrapper">
       <div class="modal-dialog">
        <div class="modal-content">
         <div class="modal-header">
	       <h4 class="modal-title">{{ modal_title }}</h4>
	       <button type="button" class="close" @click="model_producto=false">
	         <span aria-hidden="true">&times;</span>
	       </button>
         </div>
         <div class="modal-body">
          <div class="form-group">
           <label>Ingrese nombre</label>
           <input type="text" class="form-control" placeholder="Ingrese nombre" v-model="nombre" />
          </div>
          <div class="form-group">
           <label>Ingrese descripción</label>
           <textarea class="form-control" rows="3" placeholder="Ingrese descripción" v-model="descripcion"></textarea>
          </div>
          <div class="form-group">
           <label>Ingrese precio</label>
           <input type="text" class="form-control" placeholder="Ingrese precio" v-model="precio" />
          </div>
          <div class="form-group">
           <label>Seleccione proveedor</label>
            <select class="form-control" v-model="id_proveedor">
              <option value="">Seleccione un proveedor</option>
              <option v-for="proveedor in proveedores" v-bind:value="proveedor.id">
                {{ proveedor.nombre }}
              </option>
            </select>
          </div>
          <br />
          <div align="center">
           <input type="hidden" v-model="id_producto" />
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
  <script src="js/app/productos.js"></script>

<?php include_once("layouts/footer_admin.php"); ?>