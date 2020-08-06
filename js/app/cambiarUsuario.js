const url = window.$url_api;

var app_cuenta = new Vue({
 el:'#cambiarUsuario',
 data:{
  usuario:'',
  nuevo_usuario:'',
  clave:''
 },
 methods:{
  submitData:function(){
   if(app_cuenta.usuario != '' && app_cuenta.nuevo_usuario != '') {
	axios.post(url, {
	 tipo:'cambiarUsuario',
	 usuario:app_cuenta.usuario, 
	 nuevo_usuario:app_cuenta.nuevo_usuario,
	 clave:app_cuenta.clave
	}).then(function(response){
	 var estado = response.data.estado;
	 //alert(estado);alert(response.data.info);
	 app_cuenta.nuevo_usuario = '';
	 app_cuenta.clave = '';
	 if(estado == 1) {
	 	window.location.href = "index.php";
	 }
	 else if(estado == 2) {
	 	toastr.warning('La contraseña del usuario no coincide');
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
 },
 created:function(){
	axios.post(window.$url_api, {
	tipo:'recibirUsuarioSesion'
	}).then(function(response){
		app_cuenta.usuario = response.data.nombreUsuario;
	}).catch(function(error) {
		console.log('error : ' + error);
	});
 }
});