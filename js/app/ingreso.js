const url = window.$url_api;

var app_ingreso = new Vue({
 el:'#ingreso',
 data:{
  nombre:'',
  clave:''
 },
 methods:{
  submitData:function(){
   if(app_ingreso.nombre != '' && app_ingreso.clave != '') {
	axios.post(url, {
	 tipo:'ingresoUsuario',
	 usuario:app_ingreso.nombre, 
	 clave:app_ingreso.clave
	}).then(function(response){
	 app_ingreso.nombre = '';
	 app_ingreso.clave = '';
	 if(response.data.estado == true) {
	 	window.location.href = "administracion.php";
	 } else {
	 	toastr.warning('Ingreso inválido');
	 }
	}).catch(function(error) {
	 console.log('error : ' + error);
	 toastr.error('Ha ocurrido un error en el proceso');
	});
   } else {
   	toastr.warning('Complete todos los datos del formulario');
   }
  }
 }
});