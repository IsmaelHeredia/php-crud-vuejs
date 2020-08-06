const url = window.$url_api;

var app_proveedores = new Vue({
 el:'#crudProveedores',
 data:{
  proveedores:'',
  model_proveedor:false,
  modal_title:'Agregar proveedor',
 },
 methods:{
  fetchAllData:function(){
   axios.post(url, {
    tipo:'listarProveedores'
   }).then(function(response){
    app_proveedores.proveedores = response.data.proveedores;
   }).catch(function(error) {
    console.log('error : ' + error);
    toastr.error('Ha ocurrido un error en el proceso');
   });
  },
  openModel:function(){
   app_proveedores.id_proveedor = '';
   app_proveedores.nombre = '';
   app_proveedores.direccion = '';
   app_proveedores.telefono = '';
   app_proveedores.model_proveedor = true;
   app_proveedores.modal_title = 'Agregar proveedor';
  },
  submitData:function(){
   if(app_proveedores.nombre != '' && app_proveedores.direccion != '' && app_proveedores.telefono != '')
   {
    if(app_proveedores.id_proveedor == '')
    {
     axios.post(url, {
      tipo:'agregarProveedor',
      nombre:app_proveedores.nombre, 
      direccion:app_proveedores.direccion,
      telefono:app_proveedores.telefono
     }).then(function(response){
      var estado = response.data.estado;
      if(estado == 1) {
        app_proveedores.model_proveedor = false;
        app_proveedores.fetchAllData();
        app_proveedores.nombre = '';
        app_proveedores.direccion = '';
        app_proveedores.telefono = '';
        toastr.success('El proveedor fue registrado');
      } else {
        toastr.warning('El nombre del proveedor ya está en uso');
      }
     }).catch(function(error) {
      console.log('error : ' + error);
      toastr.error('Ha ocurrido un error en el proceso');
     });
    }
    else
    {
     axios.post(url, {
      tipo:'editarProveedor',
      nombre:app_proveedores.nombre, 
      direccion:app_proveedores.direccion,
      telefono:app_proveedores.telefono,
      id : app_proveedores.id_proveedor
     }).then(function(response){
      var estado = response.data.estado;
      if(estado == 1) {
        app_proveedores.model_proveedor = false;
        app_proveedores.fetchAllData();
        app_proveedores.nombre = '';
        app_proveedores.direccion = '';
        app_proveedores.telefono = '';
        app_proveedores.id_proveedor = '';
        toastr.success('El proveedor fue actualizado');
      } else {
        toastr.warning('El nombre del proveedor ya está en uso');
      }
     }).catch(function(error) {
      console.log('error : ' + error);
      toastr.error('Ha ocurrido un error en el proceso');
     });
    }
   } else {
    toastr.warning('Complete todos los datos del formulario');
   }
  },
  fetchData:function(id){
   axios.post(url, {
    tipo:'cargarProveedor',
    id:id
   }).then(function(response){
    app_proveedores.nombre = response.data.proveedor.nombre;
    app_proveedores.direccion = response.data.proveedor.direccion;
    app_proveedores.telefono = response.data.proveedor.telefono;
    app_proveedores.id_proveedor = response.data.proveedor.id;
    app_proveedores.model_proveedor = true;
    app_proveedores.modal_title = 'Editar proveedor';
   }).catch(function(error) {
    console.log('error : ' + error);
    toastr.error('Ha ocurrido un error en el proceso');
   });
  },
  deleteData:function(id){
   if(confirm("Esta seguro de borrar el proveedor ?"))
   {
    axios.post(url, {
     tipo:'borrarProveedor',
     id:id
    }).then(function(response){
     app_proveedores.fetchAllData();
     toastr.success('El proveedor fue borrado');
    }).catch(function(error) {
     console.log('error : ' + error);
     toastr.error('Ha ocurrido un error en el proceso');
    });
   }
  }
 },
 created:function(){
  this.fetchAllData();
 }
});