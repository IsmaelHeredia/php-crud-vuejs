const url = window.$url_api;

var app_cuenta = new Vue({
 el:'#cambiarClave',
 data:{
  usuario:'',
  nueva_clave:'',
  clave:''
 },
 methods:{
  submitData:function(){
   if(app_cuenta.usuario != '' && app_cuenta.nueva_clave != '') {
	axios.post(url, {
	 tipo:'cambiarClave',
	 usuario:app_cuenta.usuario, 
	 nueva_clave:app_cuenta.nueva_clave,
	 clave:app_cuenta.clave
	}).then(function(response){
	 var estado = response.data.estado;
	 app_cuenta.nueva_clave = '';
	 app_cuenta.clave = '';
	 if(estado == 1) {
	 	window.location.href = "index.php";
	 } else {
	 	toastr.warning('La contraseña del usuario no coincide');
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