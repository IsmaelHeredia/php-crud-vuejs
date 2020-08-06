const url = window.$url_api;

var app_productos = new Vue({
 el:'#crudProductos',
 data:{
  productos:'',
  model_producto:false,
  modal_title:'Agregar producto',
  proveedores:[],
 },
 methods:{
  fetchAllData:function(){
   axios.post(url, {
    tipo:'listarProductos'
   }).then(function(response){
    app_productos.productos = response.data.productos;
   }).catch(function(error) {
    console.log('error : ' + error);
    toastr.error('Ha ocurrido un error en el proceso');
   });

   axios.post(url, {
    tipo:'listarProveedores'
   }).then(function(response){
    app_productos.proveedores = response.data.proveedores;
   }).catch(function(error) {
    console.log('error : ' + error);
    toastr.error('Ha ocurrido un error en el proceso');
   });

  },

  openModel:function(){
   app_productos.id_producto = '';
   app_productos.nombre = '';
   app_productos.descripcion = '';
   app_productos.precio = '';
   app_productos.id_proveedor = '';
   app_productos.model_producto = true;
   app_productos.modal_title = 'Agregar producto';
  },
  submitData:function(){
   if(app_productos.nombre != '' && app_productos.descripcion != '' && app_productos.precio != '' && app_productos.id_proveedor != '')
   {
    if(app_productos.id_producto == '')
    {
     axios.post(url, {
      tipo:'agregarProducto',
      nombre:app_productos.nombre, 
      descripcion:app_productos.descripcion,
      precio:app_productos.precio,
      id_proveedor:app_productos.id_proveedor
     }).then(function(response){
      var estado = response.data.estado;
      if(estado == 1) {
        app_productos.model_producto = false;
        app_productos.fetchAllData();
        app_productos.nombre = '';
        app_productos.descripcion = '';
        app_productos.precio = '';
        app_productos.id_proveedor = '';
        toastr.success('El producto fue registrado');
      } else {
        toastr.warning('El nombre del producto ya está en uso');
      }
     }).catch(function(error) {
      console.log('error : ' + error);
      toastr.error('Ha ocurrido un error en el proceso');
     });
    }
    else
    {
     axios.post(url, {
      tipo:'editarProducto',
      nombre:app_productos.nombre, 
      descripcion:app_productos.descripcion,
      precio:app_productos.precio,
      id_proveedor:app_productos.id_proveedor,
      id : app_productos.id_producto
     }).then(function(response){
      var estado = response.data.estado;
      if(estado == 1) {
        app_productos.model_producto = false;
        app_productos.fetchAllData();
        app_productos.nombre = '';
        app_productos.descripcion = '';
        app_productos.precio = '';
        app_productos.id_proveedor = '';
        toastr.success('El producto fue actualizado');
      } else {
        toastr.warning('El nombre del producto ya está en uso');
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
    tipo:'cargarProducto',
    id:id
   }).then(function(response){
    app_productos.nombre = response.data.producto.nombre;
    app_productos.descripcion = response.data.producto.descripcion;
    app_productos.precio = response.data.producto.precio;
    app_productos.id_proveedor = response.data.producto.id_proveedor;
    app_productos.id_producto = response.data.producto.id;
    app_productos.model_producto = true;
    app_productos.modal_title = 'Editar producto';
   }).catch(function(error) {
    console.log('error : ' + error);
    toastr.error('Ha ocurrido un error en el proceso');
   });
  },
  deleteData:function(id){
   if(confirm("Esta seguro de borrar el producto ?"))
   {
    axios.post(url, {
     tipo:'borrarProducto',
     id:id
    }).then(function(response){
     app_productos.fetchAllData();
     toastr.success('El producto fue borrado');
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