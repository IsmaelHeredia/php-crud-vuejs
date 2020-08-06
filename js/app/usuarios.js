const url = window.$url_api;

var app_usuarios = new Vue({
 el:'#crudUsuarios',
 data:{
  usuarios:'',
  model_usuario:false,
  modal_title:'Agregar usuario',
  tipos_usuarios:[],
  bloquear_nombre:false,
  bloquear_clave:false,
 },
 methods:{
  fetchAllData:function(){

   axios.post(url, {
    tipo:'listarUsuarios'
   }).then(function(response){
    app_usuarios.usuarios = response.data.usuarios;
   }).catch(function(error) {
    console.log('error : ' + error);
    toastr.error('Ha ocurrido un error en el proceso');
   });

   axios.post(url, {
    tipo:'listarTiposUsuarios'
   }).then(function(response){
    app_usuarios.tipos_usuarios = response.data.tipos_usuarios;
   }).catch(function(error) {
    console.log('error : ' + error);
    toastr.error('Ha ocurrido un error en el proceso');
   });

  },

  openModel:function(){
   app_usuarios.id_usuario = '';
   app_usuarios.nombre = '';
   app_usuarios.clave = '';
   app_usuarios.id_tipo = '';
   app_usuarios.model_usuario = true;
   app_usuarios.modal_title = 'Agregar usuario';
   app_usuarios.bloquear_nombre = false;
   app_usuarios.bloquear_clave = false;
  },
  submitData:function(){
    if(app_usuarios.id_usuario == '')
    {
     if(app_usuarios.nombre != '' && app_usuarios.clave != '' && app_usuarios.id_tipo != '')
     {
       axios.post(url, {
        tipo:'agregarUsuario',
        nombre:app_usuarios.nombre, 
        clave:app_usuarios.clave,
        id_tipo:app_usuarios.id_tipo
       }).then(function(response){
        var estado = response.data.estado;
        if(estado == 1) {
          app_usuarios.model_usuario = false;
          app_usuarios.fetchAllData();
          app_usuarios.nombre = '';
          app_usuarios.clave = '';
          app_usuarios.id_tipo = '';
          toastr.success('El usuario fue registrado');
        } else {
          toastr.warning('El nombre del usuario ya está en uso');
        }
       }).catch(function(error) {
        console.log('error : ' + error);
        toastr.error('Ha ocurrido un error en el proceso');
       });
     } else {
      toastr.warning('Complete todos los datos del formulario');
     }
    }
    else
    {
     if(app_usuarios.id_tipo != '')
     {
       axios.post(url, {
        tipo:'editarUsuario',
        id_tipo:app_usuarios.id_tipo,
        id : app_usuarios.id_usuario
       }).then(function(response){
        app_usuarios.model_usuario = false;
        app_usuarios.fetchAllData();
        app_usuarios.nombre = '';
        app_usuarios.clave = '';
        app_usuarios.id_tipo = '';
        toastr.success('El usuario fue actualizado');
       }).catch(function(error) {
        console.log('error : ' + error);
        toastr.error('Ha ocurrido un error en el proceso');
       });
     } else {
      toastr.warning('Complete todos los datos del formulario');
     }
    }
  },
  fetchData:function(id){
   axios.post(url, {
    tipo:'cargarUsuario',
    id:id
   }).then(function(response){
    app_usuarios.nombre = response.data.usuario.nombre;
    app_usuarios.clave = '';

    app_usuarios.bloquear_nombre = true;
    app_usuarios.bloquear_clave = true;

    app_usuarios.id_tipo = response.data.usuario.id_tipo;
    app_usuarios.id_usuario = response.data.usuario.id;
    app_usuarios.model_usuario = true;
    app_usuarios.modal_title = 'Editar usuario';
   }).catch(function(error) {
    console.log('error : ' + error);
    toastr.error('Ha ocurrido un error en el proceso');
   });
  },
  deleteData:function(id){
   if(confirm("Esta seguro de borrar el usuario ?"))
   {
    axios.post(url, {
     tipo:'borrarUsuario',
     id:id
    }).then(function(response){
     app_usuarios.fetchAllData();
     toastr.success('El usuario fue borrado');
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